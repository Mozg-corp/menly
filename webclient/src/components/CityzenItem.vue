<template>
	<div class="cityzens_box__item r-flex" @click.prevent="$router.push({name: 'cityzen profile', params: {id: cityzen.id} })">
		<div class="cityzen_item__col1">
			<p>
				{{cityzen.address}}
			</p>
		</div>
		<div class="cityzen_item__col3">
			<p>
				{{cityzen.lastName}} {{cityzen.firstName}} {{cityzen.patronymic}}
			</p>
		</div>
		<div class="cityzen_item__col4">
			<p >
				{{cityzen.phoneNumber}} / {{cityzen.username}}
			</p>
		</div>
	</div><!--cityzen_box_item-->
</template>
<script>
	export default{
		name: "CityzenItem",
		props: ['cityzen'],
		computed: {
		}
	}
</script>
<style scoped lang="sass">
	.cityzens_box__item:hover
		background-color: grey
		opacity: 0.5
		color: white
</style>