const fs = require('fs');
const https = require('https');

const SUPABASE_URL = 'https://guvifomiadxehmtrqrfu.supabase.co';
const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imd1dmlmb21pYWR4ZWhtdHJxcmZ1Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzMxMDc1MjUsImV4cCI6MjA4ODY4MzUyNX0.8gy3oPTSwPXCZHAi0FbmpjkIrHQuZmWd_TE-h-L0gD8';

const tables = [
    'cidb_star_ratings',
    'shassic_scores',
    'qlassic_conquas_scores',
    'gbi_facilitator_certificates'
];

async function fetchData(table) {
    return new Promise((resolve, reject) => {
        const url = `${SUPABASE_URL}/rest/v1/${table}?select=*`;
        const options = {
            headers: {
                'apikey': SUPABASE_ANON_KEY,
                'Authorization': `Bearer ${SUPABASE_ANON_KEY}`
            }
        };

        https.get(url, options, (res) => {
            let body = '';
            res.on('data', (chunk) => body += chunk);
            res.on('end', () => {
                try {
                    resolve(JSON.parse(body));
                } catch (e) {
                    reject(e);
                }
            });
        }).on('error', reject);
    });
}

async function start() {
    for (const table of tables) {
        console.log(`Fetching ${table}...`);
        try {
            const data = await fetchData(table);
            fs.writeFileSync(`C:/Users/built/Herd/builtech-app/database/data/${table}.json`, JSON.stringify(data, null, 4));
            console.log(`Saved ${data.length} records to ${table}.json`);
        } catch (e) {
            console.error(`Failed to fetch ${table}:`, e.message);
        }
    }
}

start();
