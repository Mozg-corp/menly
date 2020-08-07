<template>
    <v-row>
      <v-col cols="12"
             v-for="card in posts"
                   :key="card.id">
                <v-card
                >
                  <router-link :to="{name:'post', params: {id: card.id}}">
                  <div class="d-flex flex-no-wrap justify-space-between">
                    <div>
                      <v-card-title
                          class="headline"
                          v-text="card.title"
                      ></v-card-title>
                      <v-card-subtitle v-text="card.preview"></v-card-subtitle>
                    </div>

                    <v-avatar
                        class="ma-3"
                        size="125"
                        tile
                    >
                      <v-img :src="card.img"></v-img>
                    </v-avatar>
                  </div>
                  </router-link>
                </v-card>
              </v-col>
            </v-row>
</template>

<script>
    import {getData} from '../lib/utils/rest-api/api-request'
    export default {
        // name: "Shops",
        data: () => ({
            posts: [],
        }),

        created() {
            this.getAllPosts();
        },

        methods: {
            getImgUrl(pic) {
                return require('../assets/home/' + pic);
            },
            getAllPosts() {

                getData('/posts').then(res=>{
                    console.log(res.data);
                    this.posts = res.data
                });
            }
        }
    };
</script>

<style scoped lang="sass">
  a
    text-decoration: none
</style>