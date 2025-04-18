// Update complaint counts
function updateCounts() {
    fetch('complaints/get-counts.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('complaints-count').textContent = data.total;
            document.getElementById('notProcessed-count').textContent = data.pending;
            document.getElementById('inProcess-count').textContent = data.in_progress;
            document.getElementById('closed-count').textContent = data.resolved;
        })
        .catch(error => console.error('Error:', error));
}

// Update date
function updateDate() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('date').textContent = now.toLocaleDateString('en-US', options);
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    updateCounts();
    updateDate();
    // Update counts every 30 seconds
    setInterval(updateCounts, 30000);
});

// Placeholder functions for button actions
function lodgeComplaint() {
    window.location.href = 'complaints/submit-complaint.php';
}

function viewComplaintStatus() {
    window.location.href = 'complaints/view-complaints.php';
}