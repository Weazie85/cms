document.addEventListener('DOMContentLoaded', function() {
    // Get all tab buttons
    var tabButtons = document.querySelectorAll(".btn.btn-light");

    // Add click event listener to each tab button
    tabButtons.forEach(function(tabButton) {
      tabButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior

        var target = this.getAttribute('data-mdb-target'); // Get the target tab content ID

        // Hide all tab contents
        var tabContents = document.querySelectorAll('.tab-pane');
        
        tabContents.forEach(function(tabContent) {
          tabContent.classList.remove('show', 'active');
        });

      // Show the selected tab content
      var selectedTab = document.querySelector(target);
      selectedTab.classList.add('show', 'active');
    });
  });
});
 