import puppeteer from "puppeteer-extra";
import { tmpdir } from "os";
import { join as pathJoin } from "path";
import { mkdtempSync, rmSync, writeFileSync, mkdirSync, readFileSync } from "fs";
import { execSync } from "child_process";
import {
    launchBrowser,
    clickIfVisible,
    isElementVisible,
    getInnerTextIfExists,
} from "./util/puppeteer-util.js";

/**
 * Save scraped data to JSON file with UUID
 * @param {Object} data - The scraped property data
 * @param {string} uuid - UUID to use as filename
 * @param {string} storageDir - Directory to save the file (default: ./storage)
 * @returns {string} - Path to the saved file
 */
const saveJsonToFile = (data, uuid, storageDir = './storage/app/public/property_api') => {
    try {
        // Create storage directory if it doesn't exist
        mkdirSync(storageDir, { recursive: true });
        
        // Generate filename with UUID
        const filename = `data_${uuid}.json`;
        const filepath = pathJoin(storageDir, filename);
        
        // Write JSON data to file
        writeFileSync(filepath, JSON.stringify(data, null, 2), 'utf-8');
        
        console.log(`💾 JSON data saved to: ${filepath}`);
        return filepath;
    } catch (error) {
        console.error(`❌ Error saving JSON file: ${error.message}`);
        throw error;
    }
};

/**
 * Load API data from JSON file
 * @param {string} apiJsonPath - Path to the API JSON file
 * @returns {Object} - Parsed JSON data
 */
const loadApiData = (apiJsonPath) => {
    try {
        const fileContent = readFileSync(apiJsonPath, 'utf-8');
        const apiData = JSON.parse(fileContent);
        return apiData;
    } catch (error) {
        console.error(`❌ Error loading API JSON: ${error.message}`);
        throw error;
    }
};

const scrapeProperty = async (page, propertyUrl) => {
    console.log(`📄 Scraping property: ${propertyUrl}`);
    
    // Navigate and wait for network to be idle
    await page.goto(propertyUrl, {
        waitUntil: "networkidle2",
    });

    // Wait for Nuxt to hydrate and render - check for actual content or 404
    await page.waitForFunction(() => {
        // Check if we have actual content (property page)
        const hasContent = document.querySelector('h2.fw-bolder, .property-info, .container, .row');
        
        // Check if we're on a 404 page
        const is404 = document.querySelector('h1')?.textContent?.includes('404') || 
                      document.querySelector('h1')?.textContent?.includes('ERROR') ||
                      document.querySelector('img[src*="404-error"]') !== null;
        
        // Return true if we have content OR if it's a 404 (so we can detect it)
        return hasContent !== null || is404;
    }, { timeout: 15000 }).catch(() => {
        console.log('⚠️ Timeout waiting for page to load, continuing...');
    });

    // Wait a bit more for Nuxt to fully render
    await new Promise(resolve => setTimeout(resolve, 2000));

    // Check if we're on a 404 page
    const is404 = await page.evaluate(() => {
        const errorText = document.querySelector('h1')?.textContent || '';
        const error404 = document.querySelector('h2')?.textContent || '';
        const errorImg = document.querySelector('img[src*="404-error"]');
        return errorText.includes('404') || 
               error404.includes('404') || 
               errorText.includes('ERROR') ||
               errorImg !== null;
    });

    if (is404) {
        throw new Error('404 page detected - property not found');
    }

    // Wait for main content - use stable selectors (Nuxt may take time to render)
    try {
        await page.waitForSelector('h2.fw-bolder, .container, .property-info', { visible: true, timeout: 30000 });
    } catch (e) {
        // If main content doesn't appear, check if it's still loading or 404
        const still404 = await page.evaluate(() => {
            const errorText = document.querySelector('h1')?.textContent || '';
            return errorText.includes('404') || errorText.includes('ERROR');
        });
        
        if (still404) {
            throw new Error('404 page detected after waiting');
        }
        
        // Wait a bit more for Nuxt to finish rendering
        await new Promise(resolve => setTimeout(resolve, 5000));
        
        // Try again
        await page.waitForSelector('h2.fw-bolder, .container, .property-info', { visible: true, timeout: 10000 });
    }

    // Extract property name
    const name = await page.$eval('h2.fw-bolder', (el) => el.textContent.trim()).catch(() => null) ||
                 await getInnerTextIfExists(page, 'h2.text-black.fw-bolder');

    // Extract description
    const description = await page.$eval('.text-details', (el) => el.textContent.trim()).catch(() => null) ||
                       await getInnerTextIfExists(page, '.text-preline.text-details');

    // Extract property code
    const propertyCode = await page.$eval('.fw-bolder.text-color.fs-3', (el) => el.textContent.trim()).catch(() => null) ||
                        await getInnerTextIfExists(page, '.fw-bolder.text-color');

    // Extract address/location
    const addressParts = await page.$$eval('.text-container img[src*="pin"]', (imgs) => {
        return imgs.map(img => {
            const parent = img.closest('.text-container');
            return parent ? parent.textContent.trim() : null;
        }).filter(Boolean);
    }).catch(() => []);

    const address = addressParts[0] || '';
    
    // Extract project name
    const projectName = await page.$$eval('.text-container img[src*="condo"]', (imgs) => {
        const parent = imgs[0]?.closest('.text-container');
        return parent ? parent.textContent.trim() : null;
    }).catch(() => null);

    // Extract rent price - get all elements and filter out "฿ 0"
    const rentPriceText = await page.$$eval('.text-color.fw-bolder.fs-3', (els) => {
        for (const el of els) {
            const text = el.textContent.trim();
            const match = text.match(/฿\s*([\d,]+)/);
            if (match) {
                const price = match[1].replace(/,/g, '');
                const priceNum = parseFloat(price);
                // Skip if price is 0
                if (priceNum > 0) {
                    return price;
                }
            }
        }
        return null;
    }).catch(() => null);

    const rentPrice = rentPriceText ? parseFloat(rentPriceText) : null;

    // Extract property details
    const details = {};
    
    // Size
    const sizeText = await page.$eval('.property-items img[src*="area"]', (img) => {
        const parent = img.closest('.property-items');
        const text = parent?.textContent || '';
        const match = text.match(/(\d+(?:\.\d+)?)\s*sq\s*m/i);
        return match ? match[1] : null;
    }).catch(() => null);
    details.sizeSqm = sizeText ? parseFloat(sizeText) : null;

    // Floor
    const floorText = await page.$eval('.property-items img[src*="floor"]', (img) => {
        const parent = img.closest('.property-items');
        const text = parent?.textContent || '';
        const match = text.match(/(\d+)/);
        return match ? parseInt(match[1]) : null;
    }).catch(() => null);
    details.floor = floorText || 1;

    // Bedrooms
    const bedroomsText = await page.$eval('.property-items img[src*="bedroom"]', (img) => {
        const parent = img.closest('.property-items');
        const text = parent?.textContent || '';
        const match = text.match(/(\d+)/);
        return match ? parseInt(match[1]) : null;
    }).catch(() => null);
    details.bedrooms = bedroomsText || 1;

    // Bathrooms
    const bathroomsText = await page.$eval('.property-items img[src*="bathroom"]', (img) => {
        const parent = img.closest('.property-items');
        const text = parent?.textContent || '';
        const match = text.match(/(\d+)/);
        return match ? parseInt(match[1]) : null;
    }).catch(() => null);
    details.bathrooms = bathroomsText || 1;

    // Extract images
    const images = [];
    
    // Main image - use stable selector without data-v, try multiple selectors
    let mainImage = null;
    try {
        mainImage = await page.$eval('.col-9 > div[style*="background-image"]', (el) => {
            const bgImage = window.getComputedStyle(el).backgroundImage;
            const match = bgImage.match(/url\(["']?([^"')]+)["']?\)/);
            return match ? match[1] : null;
        });
    } catch (e) {
        try {
            mainImage = await page.$eval('.row .col-9 > div', (el) => {
                const bgImage = window.getComputedStyle(el).backgroundImage;
                const match = bgImage.match(/url\(["']?([^"')]+)["']?\)/);
                return match ? match[1] : null;
            });
        } catch (e2) {
            // Try to find any large image container
            mainImage = await page.evaluate(() => {
                const divs = Array.from(document.querySelectorAll('div[style*="background-image"]'));
                const largeDiv = divs.find(div => {
                    const rect = div.getBoundingClientRect();
                    return rect.width > 400 && rect.height > 300;
                });
                if (largeDiv) {
                    const bgImage = window.getComputedStyle(largeDiv).backgroundImage;
                    const match = bgImage.match(/url\(["']?([^"')]+)["']?\)/);
                    return match ? match[1] : null;
                }
                return null;
            });
        }
    }
    
    if (mainImage) images.push(mainImage);

    // Gallery images - use stable selector
    const galleryImages = await page.$$eval('.img-set [style*="background-image"], .col-3 [style*="background-image"]', (els) => {
        return els.map(el => {
            const bgImage = window.getComputedStyle(el).backgroundImage;
            const match = bgImage.match(/url\(["']?([^"')]+)["']?\)/);
            return match ? match[1] : null;
        }).filter(Boolean);
    }).catch(() => []);

    images.push(...galleryImages);

    // Extract nearby places - use stable selector without data-v
    // Look for elements that contain nearby places (have img with location icons and distance)
    const nearbyPlaces = [];
    const nearbyItems = await page.$$eval('.d-flex.justify-content-between.py-2, .property-info .d-flex.justify-content-between, .col-md-8 .d-flex.justify-content-between', (items) => {
        return items.map(item => {
            const img = item.querySelector('img');
            const nameEl = item.querySelector('.text-dark, .text-color, span');
            const distanceEl = item.querySelector('.fw-bold, .fs-4');
            
            // Only process if it has an img with location-related icon
            if (!img) return null;
            
            const iconSrc = img.getAttribute('src') || '';
            const isLocationIcon = iconSrc.includes('hospital') || 
                                 iconSrc.includes('train') || 
                                 iconSrc.includes('airport') || 
                                 iconSrc.includes('school') ||
                                 iconSrc.includes('pin');
            
            if (!isLocationIcon || !nameEl) return null;

            let iconType = 'other';
            if (iconSrc.includes('hospital')) iconType = 'hospital';
            else if (iconSrc.includes('train')) iconType = 'train';
            else if (iconSrc.includes('airport')) iconType = 'airport';
            else if (iconSrc.includes('school')) iconType = 'school';

            return {
                name: nameEl.textContent.trim(),
                distance: distanceEl ? distanceEl.textContent.trim() : '',
                icon: iconType,
            };
        }).filter(Boolean);
    }).catch(() => []);

    nearbyPlaces.push(...nearbyItems);

    // Extract contacts
    const contacts = [];
    
    // Owner contacts
    const ownerContacts = await page.$$eval('.contact-container .card:first-of-type .card-body > div', (items) => {
        return items.map(item => {
            const img = item.querySelector('img');
            const text = item.textContent.trim();
            
            if (!img || !text) return null;

            const iconSrc = img.getAttribute('src') || '';
            let contactType = 'phone';
            if (iconSrc.includes('line')) contactType = 'line';
            else if (iconSrc.includes('tel')) contactType = 'phone';

            return {
                type: 'agent',
                text: text.replace(/\(Click.*\)/gi, '').trim(),
                contactType: contactType,
                icon: contactType === 'line' ? 'line' : 'phone',
            };
        }).filter(Boolean);
    }).catch(() => []);

    // Official contacts
    const officialContacts = await page.$$eval('.contact-container .card:nth-of-type(2) .card-body > div', (items) => {
        return items.map(item => {
            const img = item.querySelector('img');
            const text = item.textContent.trim();
            
            if (!img || !text) return null;

            const iconSrc = img.getAttribute('src') || '';
            let contactType = 'phone';
            if (iconSrc.includes('line')) contactType = 'line';
            else if (iconSrc.includes('tel')) contactType = 'phone';

            return {
                type: 'office',
                text: text.replace(/\(Click.*\)/gi, '').trim(),
                contactType: contactType,
                icon: contactType === 'line' ? 'line' : 'phone',
            };
        }).filter(Boolean);
    }).catch(() => []);

    contacts.push(...ownerContacts, ...officialContacts);

    // Extract facilities
    const facilities = [];
    const facilityItems = await page.$$eval('.property-items-container .property-items img', (imgs) => {
        return imgs.map(img => {
            const src = img.getAttribute('src') || '';
            const parent = img.closest('.property-items');
            const name = parent?.textContent.trim() || '';
            
            // Map facility names to IDs (you'll need to adjust these based on your facility names)
            const facilityMap = {
                'swimming': 'Swimming Pool',
                'pool': 'Swimming Pool',
                'garden': 'Garden / Park',
                'fitness': 'Gym',
                'gym': 'Gym',
            };

            for (const [key, value] of Object.entries(facilityMap)) {
                if (src.toLowerCase().includes(key) || name.toLowerCase().includes(key)) {
                    return value;
                }
            }
            return null;
        }).filter(Boolean);
    }).catch(() => []);

    // Note: Facilities will need to be resolved to IDs in Laravel command
    // For now, we'll pass the names and resolve them there

    return {
        name: name || projectName || 'Unknown Property',
        description: description || '',
        propertyCode: propertyCode || '',
        propertyType: 'condo',
        listingType: 'rent',
        rentPrice: rentPrice,
        salePrice: null,
        currency: 'THB',
        address: address,
        latitude: null, // Will be merged from API data
        longitude: null, // Will be merged from API data
        url: propertyUrl,
        details: {
            ...details,
            unitNumber: 1,
            number: propertyCode || '',
            ownership: 'freehold',
            status: 'active',
        },
        images: images,
        nearbyPlaces: nearbyPlaces,
        contacts: contacts,
        facilities: facilityItems,
        status: 'active',
    };
};

/**
 * Merge API data with scraped data
 * @param {Object} apiProperty - Property data from API
 * @param {Object} scrapedData - Data scraped from the page
 * @returns {Object} - Merged data
 */
const mergeApiAndScrapedData = (apiProperty, scrapedData) => {
    return {
        ...scrapedData,
        // Use API data for location (more accurate)
        latitude: parseFloat(apiProperty.latitude) || scrapedData.latitude,
        longitude: parseFloat(apiProperty.longitude) || scrapedData.longitude,
        // Use API data for property details if available
        details: {
            ...scrapedData.details,
            bedrooms: apiProperty.bedroom_quantity || scrapedData.details.bedrooms,
            bathrooms: apiProperty.bathroom_quantity || scrapedData.details.bathrooms,
            floor: apiProperty.floor_quantity || scrapedData.details.floor,
            sizeSqm: parseFloat(apiProperty.usable_area) || scrapedData.details.sizeSqm,
        },
        // Add API metadata
        apiId: apiProperty.id,
        apiUuid: apiProperty.uuid,
        apiTitle: apiProperty.title_th,
        apiPrice: apiProperty.price ? parseFloat(apiProperty.price) : scrapedData.rentPrice,
        apiCoverImage: apiProperty.cover_img?.url || null,
    };
};

const scarp = async () => {
    let browser;
    const userDataDir = mkdtempSync(pathJoin(tmpdir(), "puppeteer-"));
    
    try {
        // Load API data - determine project root path
        // If running from scarper directory, go up one level; if from project root, use current directory
        const currentDir = process.cwd();
        const isInScarperDir = currentDir.endsWith('scarper');
        const projectRoot = isInScarperDir ? pathJoin(currentDir, '..') : currentDir;
        const apiJsonPath = pathJoin(projectRoot, 'storage', 'app', 'public', 'api_data', 'thaolai_api_.json');
        // console.log("📂 Loading API data from:", apiJsonPath);
        const apiData = loadApiData(apiJsonPath);
        
        if (!apiData.data || !apiData.data.dataMaps || apiData.data.dataMaps.length === 0) {
            console.error("❌ No properties found in API data");
            return;
        }
        
        const properties = apiData.data.dataMaps;
        const totalProperties = properties.length;
        
        console.log(`📋 Found ${totalProperties} properties to process`);
        console.log("🚀 Launching browser...");
        
        browser = await launchBrowser(userDataDir);
        const page = await browser.newPage();
        console.log("🌐 New page created");

        await page.setUserAgent(
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36"
        );
        await page.setViewport({ width: 1280, height: 800 });

        let successCount = 0;
        let errorCount = 0;
        let skippedCount = 0;

        // Loop through all properties
        for (let i = 188; i < totalProperties; i++) {
            const apiProperty = properties[i];
            const uuid = apiProperty.uuid;
            
            console.log(`\n${'='.repeat(60)}`);
            console.log(`📋 [${i + 1}/${totalProperties}] Processing: ${apiProperty.title_th}`);
            console.log(`🔗 UUID: ${uuid}`);
            
            // Construct property URL
            const propertyUrl = `https://thaolai.com/en/assets/${uuid}/info`;
            
            // Scrape the property page with retry logic
            let scrapedData = null;
            let retries = 1;
            let lastError = null;
            
            while (retries > 0 && !scrapedData) {
                try {
                    await page.goto(propertyUrl, {
                waitUntil: "networkidle2",
                    });
                    
                    // Wait for Nuxt to fully render
                    await new Promise(resolve => setTimeout(resolve, 3000));
                    
                    // Scrape the property page
                    scrapedData = await scrapeProperty(page, propertyUrl);
                    console.log("✅ Successfully scraped property page");
                } catch (error) {
                    lastError = error;
                    retries--;
                    
                    if (error.message.includes('404')) {
                        console.error(`❌ 404 Error: Property not found (${retries} retries remaining)`);
                        if (retries === 0) {
                            console.error(`⏭️  Skipping property - 404 error`);
                            skippedCount++;
                            break; // Skip this property and continue to next
                        }
                        // Wait before retry
                        await new Promise(resolve => setTimeout(resolve, 2000));
                    } else {
                        console.error(`❌ Scraping error: ${error.message} (${retries} retries remaining)`);
                        if (retries > 0) {
                            await new Promise(resolve => setTimeout(resolve, 2000));
                        }
                    }
                }
            }
            
            if (!scrapedData) {
                if (lastError?.message.includes('404')) {
                    // Already counted as skipped
                    continue;
                } else {
                    console.error(`❌ Failed to scrape property after retries: ${lastError?.message}`);
                    errorCount++;
                    continue; // Skip this property and continue to next
                }
            }
            
            // Merge API data with scraped data
            const mergedData = mergeApiAndScrapedData(apiProperty, scrapedData);
            
            // Store JSON file in storage with UUID
            try {
                const savedFilePath = saveJsonToFile(mergedData, uuid);
                console.log(`💾 Data saved to: ${savedFilePath}`);
                successCount++;
            } catch (saveError) {
                console.error(`❌ Error saving file: ${saveError.message}`);
                errorCount++;
            }
            
            // Small delay between properties to avoid overwhelming the server
            await new Promise(resolve => setTimeout(resolve, 1000));
        }
        
        // Summary
        console.log(`\n${'='.repeat(60)}`);
        console.log(`📊 Processing Summary:`);
        console.log(`   ✅ Successfully scraped: ${successCount}`);
        console.log(`   ⏭️  Skipped (404): ${skippedCount}`);
        console.log(`   ❌ Errors: ${errorCount}`);
        console.log(`   📈 Total processed: ${successCount + skippedCount + errorCount}/${totalProperties}`);
   
    } catch (err) {
        console.error("❌ Error:", err);
    } finally {
        if (browser) {
            await browser.close();
        }
        rmSync(userDataDir, { recursive: true, force: true });
    }
};

scarp();
