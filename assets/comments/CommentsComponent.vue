<template>
    <div>
        <ol id="comments-list" reversed v-if="comments && comments.length">
            <li v-for="comment in comments" :key="comment['@id']">{{ comment.body }}</li>
        </ol>
        <p v-else>No comments yet 🙁</p>

        <form id="new-comment-form" @submit.prevent="onSubmit">
            <textarea
                    v-model="newComment"
                    name="new-comment"
                    placeholder="Your opinion matters! Send us your comment.">
            </textarea>
            <input type="submit" :disabled="!newComment">
        </form>
    </div>
</template>

<script>
    export default {
        props: {},
        data() {
            return {
                comments: [],
                newComment: '',
                news: {
                    type: String,
                    required: true
                }
            };
        },
        methods: {
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
            console.log('CommentsComponent created!');
            this.fetchComments();
        }
    }
</script>