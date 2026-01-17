import puppeteer from "puppeteer-extra";

export const launchBrowser = async (userDataDir) => {
    return puppeteer.launch({
        // headless: false,
        headless: "new",
        channel: "chrome",
        // executablePath: "/usr/bin/google-chrome",
        userDataDir,
        args: [
            // "--proxy-server=socks5://127.0.0.1:1080",
            "--no-sandbox",
            "--disable-setuid-sandbox",
            "--disable-blink-features=AutomationControlled",
            "--disable-dev-shm-usage",
            "--disable-breakpad",
            "--disable-crash-reporter",
            "--disable-software-rasterizer",
            "--disable-gpu",
            "--no-crashpad",
            "--disable-desktop-pwas",
            "--disable-features=DesktopPWAWindowing,DesktopPWAsNotificationBrowser,DesktopPWAsLinkCapturing,DesktopPWAsElidedExtensionsMenu",
            "--disable-translate"
        ],
    });
};

export const clickIfVisible = async (page, selector) => {
    try {
        await page.waitForSelector(selector, { visible: true });
        await page.click(selector);
        return true;
    } catch {
        return false;
    }
};

export const isElementVisible = async (page, selector) => {
    try {
        await page.waitForSelector(selector, { timeout: 2500, visible: true });
        return true;
    } catch {
        return false;
    }
};

export const getInnerTextIfExists = async (page, selector) => {
    try {
        await page.waitForSelector(selector, { timeout: 2500 });
        const text = await page.$eval(selector, (el) => el.innerText.trim());
        return text || null;
    } catch {
        return null;
    }
};