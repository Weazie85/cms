function validateClientForm() {

    var name = document.getElementById('clientName').value.trim();
    
    if (name === '') {
      alert('Please enter a client name.');
      return false;
    }
  
    // You can add more validation logic specific to the client form here
    return true;
  }
  
  function validateContactForm() {
    
    var name = document.getElementById('contactName').value.trim();
    var surname = document.getElementById('contactSurname').value.trim();
    var email = document.getElementById('contactEmail').value.trim();
  
    if (name === '' || surname === '' || email === '') {
      alert('Please enter all contact details.');
      return false;
    }
  
    // Validate email format using a regular expression
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    if (!emailRegex.test(email)) {
      alert('Please enter a valid email address.');
      document.form1.text1.focus();
      return false;
    }
   
    return true;
  }