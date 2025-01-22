    // Real-time date
    function updateDate() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('date').textContent = now.toLocaleDateString(undefined, options);
      }
      setInterval(updateDate, 1000);
      updateDate();
  
      // Fetch complaint status from a server (simulated here)
      function fetchComplaintStatus() {
        const fakeData = {
          complaints: 15,
          notProcessed: 5,
          inProcess: 8,
          closed: 2,
        };
  
        document.getElementById('complaints-count').textContent = fakeData.complaints;
        document.getElementById('notProcessed-count').textContent = fakeData.notProcessed;
        document.getElementById('inProcess-count').textContent = fakeData.inProcess;
        document.getElementById('closed-count').textContent = fakeData.closed;
      }
      fetchComplaintStatus();
  
      // Placeholder functions for button actions
      function lodgeComplaint() {
        alert('Lodge a complaint functionality');
      }
  
      function viewComplaintStatus() {
        alert('View complaint status functionality');
      }