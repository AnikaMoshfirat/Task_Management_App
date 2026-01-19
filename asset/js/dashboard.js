function viewDetails(section) {
    alert(`Opening detailed view for: ${section}`);
  }
  
  function quickAddTask() {
    console.log('Opening Add Task page...');
  }
  
  function viewAnalytics() {
    window.location.href = "../../view/php/progressTrack.php"; 
  }


  function viewAllTasks() {
    window.location.href = "../../view/php/searchFilterPage.php"; 
  }
  
  function viewCalendar() {
    window.location.href = "../../view/php/calenderView.php"; 
  }
