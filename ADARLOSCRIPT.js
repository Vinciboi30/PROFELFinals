let feedbacks = [];
let carouselDataLoaded = false;
const carouselData = {
    comics: {
        currentIndex: 0,
        items: []
    },
    movies: {
        currentIndex: 0,
        items: []
    },
    animated: {
        currentIndex: 0,
        items: []
    }
};

// Extract carousel data from HTML on page load
function extractCarouselDataFromHTML() {
    ['comics', 'movies', 'animated'].forEach(type => {
        // Clear existing data first to prevent duplicates
        carouselData[type].items = [];
        carouselData[type].currentIndex = 0;
        
        const track = document.getElementById(type + '-track');
        const items = track.querySelectorAll('.carousel-item');
        
        console.log(`Loading ${type} carousel:`, items.length, 'items');
        
        items.forEach((item, index) => {
            const img = item.querySelector('img');
            const box = item.querySelector('.carousel-box');
            const title = item.getAttribute('data-title') || 'Title Here';
            const desc = item.getAttribute('data-desc') || 'Description will appear here.';
            
            // Set dimensions for carousel box (BIGGER portrait orientation)
            if (box) {
                box.style.width = '500px';
                box.style.height = '750px';
            }
            
            // Set object-fit to cover for all carousel images to fill the box
            if (img) {
                img.style.objectFit = 'cover';
                img.style.width = '100%';
                img.style.height = '100%';
                console.log(`  Item ${index}: ${title}, Image: ${img.src}`);
            }
            
            carouselData[type].items.push({
                img: img ? img.src : null,
                title: title,
                desc: desc
            });
        });
        
        console.log(`${type} carousel loaded with ${carouselData[type].items.length} items`);
    });
}

function showPage(pageId) {
    const pages = document.querySelectorAll('.page');
    pages.forEach(page => page.classList.remove('active'));
    document.getElementById(pageId).classList.add('active');
    window.scrollTo(0, 0);
}

function showCarousel(type) {
    const pages = document.querySelectorAll('.page');
    pages.forEach(page => page.classList.remove('active'));
    document.getElementById(type + '-carousel').classList.add('active');
    carouselData[type].currentIndex = 0;
    updateCarousel(type);
    styleCarouselArrows();
    // Removed setupArrowListeners - using inline onclick instead
    window.scrollTo(0, 0);
}

function setupArrowListeners(type) {
    const carouselSection = document.getElementById(type + '-carousel');
    const prevBtn = carouselSection.querySelector('.carousel-nav.prev');
    const nextBtn = carouselSection.querySelector('.carousel-nav.next');
    
    if (prevBtn) {
        // Remove old listeners by cloning
        const newPrevBtn = prevBtn.cloneNode(true);
        prevBtn.parentNode.replaceChild(newPrevBtn, prevBtn);
        
        newPrevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Left arrow clicked for:', type);
            changeSlide(type, -1);
        });
    }
    
    if (nextBtn) {
        // Remove old listeners by cloning
        const newNextBtn = nextBtn.cloneNode(true);
        nextBtn.parentNode.replaceChild(newNextBtn, nextBtn);
        
        newNextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Right arrow clicked for:', type);
            changeSlide(type, 1);
        });
    }
}

function styleCarouselArrows() {
    const arrows = document.querySelectorAll('.carousel-nav');
    arrows.forEach(arrow => {
        arrow.style.background = 'linear-gradient(135deg, #fdff00 0%, #988829 100%)';
        arrow.style.boxShadow = '0 4px 15px rgba(253, 255, 0, 0.4)';
        arrow.style.width = '80px';
        arrow.style.height = '80px';
        arrow.style.fontSize = '2.5rem';
        arrow.style.fontWeight = 'bold';
        arrow.style.border = '4px solid #242424';
        arrow.style.transition = 'all 0.3s ease';
        arrow.style.cursor = 'pointer';
        arrow.style.pointerEvents = 'auto';
        arrow.style.zIndex = '1000';
        
        // Move arrows closer to the carousel
        if (arrow.classList.contains('prev')) {
            arrow.style.left = '50px';
        } else if (arrow.classList.contains('next')) {
            arrow.style.right = '50px';
        }
    });
    
    // Add hover effects separately without removing event listeners
    arrows.forEach(arrow => {
        arrow.onmouseenter = function() {
            this.style.transform = 'translateY(-50%) scale(1.15)';
            this.style.boxShadow = '0 8px 30px rgba(253, 255, 0, 0.7)';
        };
        
        arrow.onmouseleave = function() {
            this.style.transform = 'translateY(-50%) scale(1)';
            this.style.boxShadow = '0 4px 15px rgba(253, 255, 0, 0.4)';
        };
    });
}

function changeSlide(type, direction) {
    const data = carouselData[type];
    
    // Make sure we have items
    if (!data.items || data.items.length === 0) {
        console.error('No items in carousel:', type);
        return;
    }
    
    console.log('BEFORE:', type, 'currentIndex:', data.currentIndex, 'direction:', direction, 'total items:', data.items.length);
    
    data.currentIndex += direction;
    
    // Wrap around logic
    if (data.currentIndex < 0) {
        data.currentIndex = data.items.length - 1;
    } else if (data.currentIndex >= data.items.length) {
        data.currentIndex = 0;
    }
    
    console.log('AFTER:', type, 'currentIndex:', data.currentIndex);
    updateCarousel(type);
}

function updateCarousel(type) {
    const data = carouselData[type];
    const track = document.getElementById(type + '-track');
    const offset = -data.currentIndex * 100;
    track.style.transform = `translateX(${offset}%)`;
    
    const currentItem = data.items[data.currentIndex];
    if (currentItem) {
        document.getElementById(type + '-title').textContent = currentItem.title;
        document.getElementById(type + '-desc').textContent = currentItem.desc;
    }
    
    // Make description box bigger
    const descBox = document.querySelector(`#${type}-carousel .carousel-description`);
    if (descBox) {
        descBox.style.padding = '3rem';
        descBox.style.minHeight = '200px';
        descBox.style.fontSize = '1.2rem';
    }
    
    const descTitle = document.getElementById(type + '-title');
    if (descTitle) {
        descTitle.style.fontSize = '2.5rem';
        descTitle.style.marginBottom = '1.5rem';
    }
    
    const descText = document.getElementById(type + '-desc');
    if (descText) {
        descText.style.fontSize = '1.3rem';
        descText.style.lineHeight = '1.8';
    }
    
    console.log('Updated carousel:', type, 'Index:', data.currentIndex, 'Offset:', offset + '%');
}

document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const comment = document.getElementById('comment').value;
    feedbacks.unshift({
        name: name,
        email: email,
        comment: comment,
        date: new Date().toLocaleDateString()
    });
    displayFeedbacks();
    this.reset();
    alert('Thank you for your feedback!');
});

function displayFeedbacks() {
    const feedbackList = document.getElementById('feedbackList');
    if (feedbacks.length === 0) {
        feedbackList.innerHTML = '<h2>Recent Feedback</h2><p style="text-align: center; color: #988829;">No feedback yet. Be the first to share your thoughts!</p>';
        return;
    }
    let html = '<h2>Recent Feedback</h2>';
    feedbacks.forEach(feedback => {
        html += `
            <div class="feedback-item">
                <h4>${feedback.name} - ${feedback.date}</h4>
                <p>${feedback.comment}</p>
            </div>
        `;
    });
    feedbackList.innerHTML = html;
}

// Initialize carousel data from HTML when page loads
window.addEventListener('DOMContentLoaded', function() {
    if (!carouselDataLoaded) {
        extractCarouselDataFromHTML();
        carouselDataLoaded = true;
    }
    displayFeedbacks();
    styleCarouselArrows();
});
// ... all your existing code above ...

// Initialize carousel data from HTML when page loads
window.addEventListener('DOMContentLoaded', function() {
    if (!carouselDataLoaded) {
        extractCarouselDataFromHTML();
        carouselDataLoaded = true;
    }
    displayFeedbacks();
    styleCarouselArrows();
});

// ADD THIS NEW CODE HERE AT THE BOTTOM:
// Footer feedback form handler
document.getElementById('footerFeedbackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('footer-name').value;
    const email = document.getElementById('footer-email').value;
    const suggestion = document.getElementById('footer-suggestion').value;
    
    // Add to feedbacks array
    feedbacks.unshift({
        name: name,
        email: email,
        comment: suggestion,
        date: new Date().toLocaleDateString()
    });
    
    // Reset form
    this.reset();
    
    // Show success message
    alert('Thank you for your feedback! Your suggestions help us improve The Batman Collection.');
    
    // Update feedback list if on feedback page
    displayFeedbacks();
});