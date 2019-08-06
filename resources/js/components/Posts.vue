<template>
    <div>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div v-for="post in posts" class="col-md-6 mb-4 d-flex">
                        <div class="item">
                            <p class="image"><img :src="post.image" alt=""></p>
                            <p class="title">{{post.title}}</p>
                            <a :href="singlePostUrl(post.friendly_url)">detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <section class="sidebar">
                    <aside v-if="recent">
                        <h3>Recentes</h3>
                        <ul>
                            <li v-for="post in recent"><a :href="'blog/' + post.friendly_url">{{ post.title }}</a></li>
                        </ul>
                    </aside>
                </section>
            </div>
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
        props: {
            recent: {
                type: Object
            }
        },
        methods: {
            list() {
                axios.get('/api/posts').then(response => {
                    this.posts = response.data.data;
                });

            },
            singlePostUrl(slug) {
                return 'blog/' + slug
            }
        },
        mounted() {
            this.list()
        }
    }
</script>

<style lang="scss">
    .item {
        border: 1px solid #2c2c2c;
        background: #2c2c2c;

        .image {
            padding: 2px;
            background: #000;
        }

        .title {
            padding: 14px;
            font-size: 1.3em;
            font-weight: 400;
            color: #fff;
            line-height: 1.4;
        }

        a {
            margin: 14px;
            padding: 10px 20px;
            background: #b0d91b;
            color: #fff;
            text-transform: uppercase;
            display: block;
            text-align: center;
            font-weigth: 700;

            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            -ms-border-radius: 3px;

            &:hover {
                background: #c0e149;
                text-decoration: none;
            }
        }
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

    .sidebar {
        padding: 10px 0;
        background: #2c2c2c;
        border: 1px solid #000;
        box-shadow: 0 2px 2px #000;

        .sidebar {
            padding: 10px 0;
            background: #2c2c2c;
            border: 1px solid #000;
            box-shadow: 0 2px 2px #000;

            aside {
                h3 {
                    font-size: 1.1em;
                    font-weight: 400;
                    color: #eee;
                    text-transform: uppercase;
                    margin-bottom: 10px;
                    padding: 10px 14px;
                    border-bottom: 1px solid #212121;
                }

                ul {
                    margin: 0;
                    padding: 20px;

                    li {
                        margin-bottom: 14px;

                        a {
                            color: #eee;
                            transition: .36se ease-in-out;
                            -moz-transition: .36se ease-in-out;
                            -webkit-transition: .36se ease-in-out;
                            -ms-transition: .36se ease-in-out;

                            &:hover {
                                text-decoration: none;
                                color: #c0e149;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
