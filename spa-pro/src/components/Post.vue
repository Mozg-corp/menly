<template lang="html">
  <v-container id="inspire">
          <v-card flat>
            <v-card-text >
			  <span>{{post.postedAt}}</span>
			  <v-img :src="post.img === ''?'':post.img"/>
              <h2>{{post.title}}</h2> 
              <p>{{post.body}}</p>
            </v-card-text>
          </v-card>
  </v-container>

</template>

<script>
    import {getData} from "../lib/utils/rest-api/api-request";
	import Vue from 'vue';

    export default {
        name: 'Post',
        props: ['id'],
        components: {},
        data: () => ({
            post: {title: '', preview: '', body: '', img: '', postedAt: ''},
        }),
        methods: {
            getPost() {
                getData('/posts/' + this.id).then(res => {
                    // console.log(res.data);
                    this.post = res.data;
			//console.log(this.post.img);
					
                })
            },
        },

        created() {
            console.log("created");
            // console.log(this.id);
            this.getPost();
        },

        watch: {
            // search(after, before) {
            //     this.searcher();
            // }
        }
    }
</script>

<style scoped lang="sass">
  h2,h3, p
    margin: 5px 0

</style>