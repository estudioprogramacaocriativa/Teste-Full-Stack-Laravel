<template>
    <div>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div v-for="post in posts" class="col-md-4 mb-4">
                        <div class="item">
                            <p>{{post.title}}</p>
                            <a href="#" @click="find(post.id)">detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <aside>
                    <h3>Recentes</h3>
                </aside>
                <aside>
                    <h3>Tags</h3>
                </aside>
                <aside>
                    <h3>Top autores</h3>
                </aside>
            </div>
        </div>

        <div class="post" v-if="modal">
            <a href="#" @click="modal = false">fechar</a>
            <h1>{{post.title}}</h1>
            <p>{{post.body}}</p>
            tags:
            <ul class="tags">
                <li v-for="tag in post.tags">{{ tag }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: [],
                post: {},
                modal: false
            }
        },
        methods: {
            list() {

                axios.get('/api/posts').then(response => {
                    this.posts = response.data;
                });

            },
            find(id) {

                axios.get('/api/posts/' + id).then(response => {
                    this.post = response.data;
                    this.open_modal()
                });

            },
            open_modal() {
                this.modal = true
            }
        },
        mounted() {
            this.list()
        }
    }
</script>

<style>
    .item {
        border: 1px solid #ccc;
    }

    .post {
        position: absolute;
        top: 0;
        left: 50%;
        z-index: 99;
        width: 800px;
        height: auto;
        margin-left: -400px;
        padding: 10px;
        background-color: #eaeaea;
        color: #333;
        border: 1px solid #6E6E6E;

    }

    .post a {
        float: right;
        color: red;
    }
</style>
