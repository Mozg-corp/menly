<template>
	<div v-if="loading" class="profile_container r-flex">
			Loading...
	</div>
	<div v-else id="cityzens" class="profile_container__main cityzens">
		<h2 class="cabinet_header">
			Платежи
		</h2>	
	</div>
</template>
<script>
	import {mapActions, mapState} from 'vuex';
	import CityzenItem from '@/components/CityzenItem';
	export default{
		name: 'Payments',
	}
</script>
<style scoped lang="sass">
	.cityzens
		width: 100%
	.cabinet_header
		width: 100%
	.cityzens_box
		flex-direction: column
		font-size: 18px
		line-height: 22px
		color: #000000
		justify-content: space-beetween
	.cityzens_box__item
		flex-wrap: nowrap
		margin: 8px 0
	.cityzen_item__col1
		flex-grow: 1
		flex-basis: 150px
	.cityzen_item__col2
		flex-grow: 1
		flex-basis: 100px
	.cityzen_item__col3
		flex-grow: 9
		flex-basis: 0
	.cityzen_item__col4
		flex-grow: 1
		font-size: 18px
		line-height: 22px
		color: #000000
	.sendClaim
		font-weight: 500
		font-size: 18px
		line-height: 40px
		text-align: center	
		color: #000000
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		background-color: #C0BFFF
		border-radius: 10px
		padding: 8px 34px
	.sendClaim_container
		margin: 44px 0 0 0
		width: 100%
		text-align: center
	.mg-l40
		margin-left: 40px
</style>