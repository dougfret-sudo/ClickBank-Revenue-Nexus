/**
 * ClickBank Revenue Nexus - Dashboard Controller
 * Connects UI buttons to the Python Backend.
 */

// 1. Logic for the [Place Ad] button
async function placeAd() {
    const statusMsg = document.getElementById('status-msg');
    statusMsg.innerText = "Nexus Engine: Deploying secure bridge page...";

    try {
        const response = await fetch('http://127.0.0', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'deploy' })
        });
        
        const result = await response.json();
        statusMsg.innerText = `System: ${result.msg}`;
    } catch (error) {
        statusMsg.innerText = "Connection Error: Is the Python Engine running?";
    }
}

// 2. Logic for the [Generate Income] button
async function fetchRevenue() {
    const ticker = document.getElementById('revenue-ticker');
    const statusMsg = document.getElementById('status-msg');
    statusMsg.innerText = "Syncing verified income data...";

    try {
        const response = await fetch('http://127.0.0');
        const data = await response.json();
        
        // Updates the span id="revenue-ticker" from your HTML
        ticker.innerText = `$${data.total_revenue.toFixed(2)}`;
        statusMsg.innerText = "Revenue Synchronized.";
    } catch (error) {
        statusMsg.innerText = "Sync Failed. Check ClickBank Webhook status.";
    }
}
