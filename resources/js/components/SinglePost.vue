<template>
    <div>
        <div class="row">
            <div class="col-md-9">
                <article class="item">
                    <p class="image"><img :src="post.image" alt=""></p>
                    <header>
                        <h1 class="title">{{post.title}}</h1>
                        <p>
                            <time>Em <b>{{post.created_at}}</b></time>
                            <b class="separator">|</b>
                            <span>por <b>{{post.author.name}}</b></span>
                        </p>
                    </header>
                    <p class="mt-3 body">{{post.body}}</p>
                    <nav class="tags">
                        <h4>Tags</h4>
                        <ul>
                           <li v-for="tag in post.tags">{{ tag }}</li>
                        </ul>
                    </nav>
                </article>
            </div>
            <div class="col-md-3">
                <section class="sidebar">
                    <aside v-if="recent">
                        <h3>Recentes</h3>
                        <ul>
                            <li v-for="post in recent"><a :href="post.friendly_url">{{ post.title }}</a></li>
                        </ul>
                    </aside>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            post: {
                type: Object,
                required: true
            },
            recent: {
                type: Object
            }
        },
        watch: {
            post(value) {
                this.post = value

                console.log(this.post)
            }
        },
        methods: {

        }
    }
</script>

<style lang="scss">
    .item {
        .tags {
            text-align: center;
            padding: 20px;
            color: #fff;
            border-top: 1px solid #212121;
            margin-top: 20px;
            padding: 20px 20px 40px 20px;

            h4 {
                font-size: 1em;
                font-weight: 700;
                color: #eee;
                margin-bottom: 20px;
                text-transform: uppercase;
                display: table;
                width: 100%;
            }

            li {
                display: inline;
                margin: 0 0 0 10px;
                padding: 4px 14px;
                border-radius: 25px;
                -moz-border-radius: 25px;
                -webkit-border-radius: 25px;
                -ms-border-radius: 25px;
                background: #c0e149;
                color: #2c2c2c;
            }
        }

        .body {
            color: #eee;
            border-top: 1px solid #212121;
            margin-top: 20px;
            padding: 20px;
        }

        border: 1px solid #2c2c2c;
        background: #2c2c2c;

        .image {
            padding: 2px;
            background: #000;
        }

        header {
            padding: 20px;

            p {
                time {
                    color: #eee;
                    font-size: .876em;
                }

                span {
                    font-size: .876em;
                    color: #b0d91b;
                }

                .separator {
                    margin: 0 10px;
                    color: #aaa;
                }
            }

            .title {
                font-size: 1.3em;
                font-weight: 400;
                color: #fff;
                line-height: 1.4;
                margin: 0;
                padding: 0;
            }
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
</style>
