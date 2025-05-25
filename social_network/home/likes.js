document.addEventListener("DOMContentLoaded", function() {
    const userId = 1; 

    document.querySelectorAll('.post__like').forEach(likeButton => {
        likeButton.addEventListener('click', async function() {
            console.log("like clicked");
            const post = this.closest('.post');
            await toggleLike(post, userId);
        });
    });

    async function toggleLike(post, userId) {
        const postId = post.dataset.postId; 
        console.log("toggle");
        
        try {
            const response = await fetch(`../data/toggle_like.php?user_id=${userId}&post_id=${postId}`, {
                method: 'GET' 
            });
            
            const data = await response.json(); 
            
            if (!data.error) {
                const counter = post.querySelector('.post__like .counter');
                if (counter) {
                    counter.textContent = data.likes_count;
                }
                
                const likeButton = post.querySelector('.post__like');
                likeButton.classList.toggle('active', data.is_liked);
            } else {
                alert(data.error);
                console.error('Error:', data.error);
            }
        } catch (error) {
            alert(data.error);
            console.error('Fetch error:', error);
        }
    }
});