document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('commentForm');
    const commentText = document.getElementById('commentText');
    const charCount = document.getElementById('charCount');
  
    // Function to update character count
    const updateCharCount = () => {
      const currentLength = commentText.value.length;
      charCount.textContent = `${currentLength}/1500`;
      // Change color if limit exceeded
      if (currentLength > 1500) {
        charCount.style.color = 'red';
      } else {
        charCount.style.color = 'black';
      }
    };
  
    // Event listener for typing in the textarea
    commentText.addEventListener('input', updateCharCount);
  
    // Form submission event
    commentForm.addEventListener('submit', function(event) {
      event.preventDefault();
  
      // Trim whitespace
      const commentTrimmed = commentText.value.trim();
  
      // Check if the comment is blank
      if (!commentTrimmed) {
        alert('Comment cannot be blank.');
        commentText.style.borderColor = 'red'; // Highlight the text area
        return false;
      }
  
      // Check character limit (though HTML5 'maxlength' prevents typing beyond limit)
      if (commentTrimmed.length > 1500) {
        alert('Comment must be 1500 characters or less.');
        commentText.style.borderColor = 'red'; // Highlight the text area
        return false;
      }
  
      // If validation passes
      commentText.style.borderColor = ''; // Reset text area border color
    });
  
    // Reset button event listener
    commentForm.addEventListener('reset', function() {
      commentText.value = '';
      charCount.textContent = '0/1500';
      commentText.style.borderColor = '';
    });
  
    // Hide error message initially
    const errorText = document.getElementById('error-text-question');
    errorText.style.display = 'none';
  });