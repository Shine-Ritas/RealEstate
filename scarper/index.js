import puppeteer from "puppeteer-extra";
import { tmpdir } from "os";
import { join as pathJoin } from "path";
import { mkdtempSync,rmSync } from "fs";
import {
    launchBrowser,
    clickIfVisible,
    isElementVisible,
    getInnerTextIfExists,
} from "./util/puppeteer-util.js";

const scarp = async () => {
    let browser;
    const userDataDir = mkdtempSync(pathJoin(tmpdir(), "puppeteer-"));
    try {
        console.log("🚀 Launching browser...");
        browser = await launchBrowser(userDataDir);
        const page = await browser.newPage();
        console.log("🌐 New page created");

        await page.setUserAgent(
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36"
        );
        await page.setViewport({ width: 1280, height: 800 });

        console.log("🌍 Navigating to Thaolai");
        await page.goto(
            "https://thaolai.com/en/assets",
            {
                waitUntil: "networkidle2",
            }
        );

        console.log("🔍 Waiting for card containers...");
        await page.waitForSelector('.card-container', { visible: true });
        
        console.log("🖱️ Clicking first card...");
        const firstCard = await page.$('.card-container');
        if (firstCard) {
            const firstCardChild = await firstCard.$(':first-child');
            if (firstCardChild) {
                await firstCardChild.click();
                console.log("✅ First card clicked!");
            } else {
                console.log("⚠️ First card container has no child element");
            }
        } else {
            console.log("⚠️ No card containers found");
        }


    } catch (err) {
        
    }
    finally {
       
    }
};


scarp();