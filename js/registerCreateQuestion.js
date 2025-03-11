function validateTextLength(textareaId, errorMessageId, minLength, maxLength) {
    const textarea = document.getElementById(textareaId);
    const errorMessage = document.getElementById(errorMessageId);
  
    if (textarea.value.length < minLength || textarea.value.length > maxLength) {
      errorMessage.textContent = `Error: Text must be between ${minLength} and ${maxLength} characters.`;
      alert(errorMessage.textContent)
    } else {
      errorMessage.textContent = '';
    }
  }
  
  const textarea = document.getElementById('writingArea');
  const errorMessage = document.getElementById('error-text-question');
  const submitButton = document.getElementById('upload');
  const resetButton = document.getElementById('Reset');
  
  submitButton.addEventListener('click', function() {
    validateTextLength('writingArea', 'error-text-question', 20, 1500);
  });

  resetButton.addEventListener('click', function() { 
    textarea.value = '';
    errorMessage.classList.remove('error-text');
    errorMessage.textContent = '';
  });