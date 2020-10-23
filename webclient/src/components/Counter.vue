<template>
	<div v-if="loading" class="profile_container r-flex">
			Loading...
	</div>
	<div v-else id="payments" class="tabcontent" style="display: block;">
	
			<CounterItem v-for="house in counters" :house="house"/>
			
	</div>
</template>

<script>
import {mapState, mapActions} from 'vuex';
import CounterItem from '@/components/CounterItem.vue';
export default{
	name: 'Counter',
	data: ()=>({
		loading: false,
		data: []
	}),
	components: {
		CounterItem
	},
	computed: {
		...mapState(['counters'])
	},
	methods: {
		...mapActions(['fetchCounters'])
	},
	mounted(){
		this.loading = true;
		this.fetchCounters()
			.then( data => {
				this.loading = false;
				//this.data = data.reduce( (acc, cur) => ({...acc, [cur.houseNumber]: [...acc[cur.houseNumber], cur]}), {})
				//console.log('dsafsdag', data);
			})
	}
}
</script>

<style scoped lang="sass">

	
</style>