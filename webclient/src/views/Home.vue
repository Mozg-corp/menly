<template>
	<router-view :key="$route.path" />
</template>

<script>
// @ is an alias to /src
import {mapGetters, mapActions, mapState, mapMutations} from 'vuex';
export default {
  name: 'home',
  data: ()=> ({
  }),
  components: {
  },
  computed: {
	...mapState([]),
	...mapGetters([]),
	
	
  },
  methods:{
	...mapMutations([]),
	...mapActions([
	]),
  },
  
  mounted(){
  }
}
</script>
<styles scoped lang="sass">
	
</styles>