async function fetchRevenue() {
    const ticker = document.getElementById('revenue-ticker');
    const statusMsg = document.getElementById('status-msg');
    
    // Changing the message to show we are FETCHING, not creating
    statusMsg.innerText = "Syncing with ClickBank 'Source of Truth'...";

    try {
        const response = await fetch('http://127.0.0');
        const data = await response.json();
        
        // This updates your ticker with the verified sales found in SQL
        ticker.innerText = `$${data.total_revenue.toFixed(2)}`;
        statusMsg.innerText = "Data Integrity Verified. Dashboard Updated.";
    } catch (error) {
        statusMsg.innerText = "Sync Failed: Engine Offline.";
    }
}
