<template>
<div>
	<div class="home_top">
			<b-container>
				<h2 class="home_top_heading">
					Машина
				</h2>
			</b-container>
		</div>
	<b-container>
		<div class="row_car">
			<b-row 
				align-h="center"
				class="pt-4 "
			>
				<b-col v-if="loadingUserData" class="text-center">
					<b-spinner 
						variant="dark"
						type="grow"
					></b-spinner>
				</b-col>
				<b-col v-else>
					<div >
						<h2 class="fio pb-3">
							
						</h2>
						<div class="d-flex justify-content-between">
							<p>
								<b>Марка</b>
							</p>
							<p>
								{{user.car&&user.car.brand}}
							</p>
						</div>
						<div class="d-flex justify-content-between">
							<p>
								<b>Модель</b>
							</p>
							<p>
								{{user.car&&user.car.model}}
							</p>
						</div>
						<div class="d-flex justify-content-between">
							<p>
								<b>Цвет</b>
							</p>
							<p>
								{{user.car&&user.car.color}}
							</p>
						</div>
						<div class="d-flex justify-content-between">
							<p>
								<b>Год</b>
							</p>
							<p>
								{{user.car&&user.car.year}}
							</p>
						</div>
					</div>
				</b-col>
			</b-row>
		</div>
	</b-container>
</div>
</template>
<script>
import { mapState} from 'vuex';
export default{
	name: 'Car',
	components: {},
	props: [],
	data: ()=>({}),
	computed: {
		...mapState(['user', 'loadingUserData'])
	},
	mouted(){},
	created(){}
}
</script>
<style scoped lang="sass">
.fio
	font-size: 14px
	font-weight: bold
.row_car
	max-width: 400px
	margin: 0 auto
</style>