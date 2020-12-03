<template>
<div>
	<div class="home_top">
			<b-container>
				<h2 class="home_top_heading">
					Профиль
				</h2>
			</b-container>
		</div>
	<b-container>
		<div class="row_car">
			<b-row class="pt-4">
				<b-col v-if="loadingUserData" class="text-center">
					<b-spinner 
						variant="dark"
						type="grow"
					></b-spinner>
				</b-col>
				<b-col v-else>
					<div >
						<div class="d-flex justify-content-between">
							<p>
								<b>ФИО</b>
							</p>
							<p>
								{{user.profile&&user.profile.fio}}
							</p>
						</div>
						<div class="d-flex justify-content-between">
							<p>
								<b>Зарегистрирован</b>
							</p>
							<p>
								{{user.profile&&(new Date(user.create_at)).toLocaleDateString()}}
							</p>
						</div>
						<div class="d-flex justify-content-between">
							<p>
								<b>д.р. </b>
							</p>
							<p>
								{{user.profile&&(new Date(user.profile.birthdate)).toLocaleDateString()}}
							</p>
						</div>
						<div class="d-flex justify-content-between">
							<p>
								<b>Телефон</b>
							</p>
							<p>
								{{user.profile&&user.profile.phone}}
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
	name: 'Profile',
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