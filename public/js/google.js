const object = {
private_key: "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDF2iJvzirscFPR\nIxmBh9NcQYly8RdXGi9uGb3dTww2JLxYk4MCHnLbxFZumPWOsUXRCYfJQE/xFrq1\n2COtFwkSiD2w0MmXHQl1DIoGBErMtBpmq2qHpBJA5kXPGWxo9TNzSrtpJDprYQGS\nXcJer5qedRNUhQe7lK+As4fn9ZZS7Usc6ZfVyvg+9y9cTW8GvP+gz1Out7kRN9EG\npUyRHEo+SZKTnh7rSraN9V/srz0uqguDOok+gvongunCeTxzRqqiPpJCymfT5ZzX\nGPY8q1wWfG/peZJWpMa7jQ24/gM9mISKfZAQc+avq2NErszbBUAstBdBil6ZA2gp\nxFQL08GbAgMBAAECggEAVZ33mPpWiMpy+uV9fBgS1rFlkV/TAdZLABITn1k9p5Bu\nEMaEwr36Zi+oV2PJn14HIFZHdEdoUKPNWDOX/KcjPenHCGTRV5sxJH2wnLnuxHaL\nljJHfzr4yyzauKv/xcuV4CZOw0jyHtVzoKsCGYdUGY4AN2r51aqZ58/I2A/mZSuX\nCDiphVbKoIieua37Kne/sRcni5S7ohpWVoc3kbkEC6spqL+V8F1jI4cqD2uO3CGr\n0hhD5tYtf4UvDOTEWvY33OpFk59kfSeNtfisiR/iLczxi8fhMcTy9AyKxr1oCum7\n3DceE2wMpu8sBHNy0tTT8Abp3K0t/U5xkuxNBhaDQQKBgQD0nwCKOqQwcgmhOTvE\nQhzrjasClzAud001GfeQ/Nk8eD6U2JaSUoVZYExE0bCFRZNGtoR5LE+lkAdIeFjt\nojlezTODcBp2JMFksVzc1fxNlIdMC636wq61kbHW9nQKzC/LdyHMZuaZl0dbPUJ+\nruyWHh9VLdnyYVCkHHzymM1atwKBgQDPDjKNOhewHsotRthI/Fk3c8ZurNSHby8Q\neIH87LgiKwF7ox2DpIMKH6FUGGqxxmvWdUt+D8x1QN+o7O9oT4xeN/UnihEkxVjW\ndrOgpHWdzUj8pb559IdR28wPOqE8CGSwpSHmX9/E8bi2UmLsjc447OdIOAWKF4Xb\nzE4Y2i/8PQKBgQDnxwAr+QQ5ItQc/q2ydzIPvluaSMZOQJvXBJOdvPXYZdZmEhIY\n8jeHR8b8LfKjVBkHl0hNx75vkNhVwjIAdwUE3klA8Kch6hGT5rmmRNqaZ3EKjMZ8\nIpqHT1TB6SJqWK2wi2Bq29UDEmN5/8FRZ0yjsEbf3mHzVmGiHZwGAOISYQKBgFD1\ncyynT0XM9C556e23xcaZ3Te/GiaOga+F/wV/JYwulpjaMZscgyQ9M95m4aj7NYUY\nPdlfogkiwZESe5WkrPTWGmRIZuWiyFaq+RdR1q9J6kTnJbAXvaVzNLmrqgmIGp67\nIqMqT5t5DEk1s3pdBApcDx680OWqxusnWk37WhHdAoGBALEwz3RBG5f3/C2vcjfj\nXiY9cfsdPXko0IHSVi3NPeAYbY9QmV7L7aX6o1NNKoAhCGmOs+JzD0gzSe4mAmNu\nSeQvdnk3pidJ0A1pXnupndJytlgTOXlI24HIV6DkfHJAnkLZTjP5gATbl02gaPG2\nMXGsqb2g+/xhhws2DfVDO8F2\n-----END PRIVATE KEY-----\n",
    client_email: "future@future-cfdb6.iam.gserviceaccount.com",
    scopes: ["https://www.googleapis.com/auth/drive.readonly"],
};

const DISCOVERY_DOC = 'https://sheets.googleapis.com/$discovery/rest?version=v4';

function gapiLoaded() {
    gapi.load('client', initializeGapiClient);
}   

async function initializeGapiClient() {
    gapi.auth.setToken(await GetAccessTokenFromServiceAccount.do(object));

    await gapi.client.init({
    //apiKey: API_KEY,
    discoveryDocs: [DISCOVERY_DOC],
    });
    gapiInited = true;
    //maybeEnableButtons();
}

async function getData() {
    let response;
    try {
        // Fetch first 10 files
        response = await gapi.client.sheets.spreadsheets.values.get({
        //spreadsheetId: '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms',
        spreadsheetId: '1eo2WSB8tOERR_xirStEfrCgs65jmzXFKGZq1Gat4Zz4',
            range: '시트2!A2:B6',
        });
    } catch (err) {
        document.getElementById('content').innerText = err.message;
        return;
    }
    const range = response.result;
    if (!range || !range.values || range.values.length == 0) {
        document.getElementById('content').innerText = 'No values found.';
        return;
    }
    console.log(range);
    // Flatten to string to display
    const output = range.values.reduce(
        (str, row) => `${str}${row[0]}, ${row[4]}\n`,
        'Name, Major:\n');
    document.getElementById('content').innerText = output;
}

