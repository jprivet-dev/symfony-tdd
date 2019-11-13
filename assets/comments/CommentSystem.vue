<template>
    <div>
        <ol reversed v-if="comments.length">
            <li v-for="comment in comments" :key="comment['@id']">{{ comment.body }}</li>
        </ol>

        <p v-else>No comments yet 🙁</p>

        <form id="post-comment" @submit.prevent="onSubmit">
            <textarea name="new-comment" v-model="newComment" placeholder="Your opinion matters! Send us your comment.">
            </textarea>
            <input type="submit" :disabled="!newComment">
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            news: {
                type: String,
                required: true
            }
        },
        methods: {
            data() {
                return {
                    comments: [],
                    newComment: '',
                };
            },
            fetchComments() {
                fetch(`/api/comments?news=${encodeURIComponent(this.news)}`)
                    .then((response) => response.json())
                    .then((data) => this.comments = data['hydra:member']);
            },
            onSubmit() {
                fetch('/api/comments', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/ld+json',
                        'Content-Type': 'application/ld+json'
                    },
                    body: JSON.stringify({news: this.news, body: this.newComment})
                }).then(({ok, statusText}) => {
                    if (!ok) {
                        alert(statusText);
                        return;
                    }

                    this.newComment = '';
                    this.fetchComments();
                });
            }
        },
        created() {
            console.log('CommentSystem created!');
            this.fetchComments();
        }
    }
</script>