document.addEventListener('DOMContentLoaded', function() {
    const maskedWords = document.querySelectorAll('.cg-word');
    
    maskedWords.forEach(word => {
        word.addEventListener('click', function() {
            if (!this.classList.contains('cg-revealed')) {
                this.classList.add('cg-revealed');
            }
        });
    });
});
