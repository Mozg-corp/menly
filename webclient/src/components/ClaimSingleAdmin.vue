<template>
	<div v-if="loading" class="profile_container r-flex">
			Loading...
	</div>
	<div v-else id="claims" class="profile_container__main claims">
		<h2 class="cabinet_header">
			ОБРАЩЕНИЯ
		</h2>	
		<div class="claim_container r-flex">
			<div class="claim_row r-flex">
				<div >
					<p class="row_header">
						Дата:
					</p>
				</div>
				<div>
					<p class="row_content">
						{{singleClaim.creationDate}}
					</p>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<p class="row_header">
						Тема:
					</p>
				</div>
				<div>
					<p class="row_content">
						{{singleClaim.title}}
					</p>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<p class="row_header">
						ФИО:
					</p>
				</div>
				<div>
					<p class="row_content linkable" @click.prevent="$router.push({name: 'cityzen profile', params: {id: singleClaim.authorId}})">
						
						{{singleClaim.authorName.lastname}} {{singleClaim.firstName}} {{singleClaim.authorName.patronymic}}
					</p>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<p class="row_header">
						Телефон:
					</p>
				</div>
				<div>
					<p class="row_content">
						{{singleClaim.phoneNumber}}
					</p>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<p class="row_header">
						Текст:
					</p>
				</div>
				<div>
					<p class="row_content">
						{{singleClaim.text}}
					</p>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<p class="row_header">
						Фото:
					</p>
				</div>
				<div>
					<p class="row_content">
						{{singleClaim.photoLinks}}
					</p>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<p class="row_header">
						Статус:
					</p>
				</div>
				<div>
					<select @change="selectStatusHandler($event)">
						<option v-for="status in statuses" :selected="status===singleClaim.status?'selected':''" >
							{{status}}
						</option>
					</select>
				</div>
			</div>
			<a href="#" @click.prevent="$router.go(-1)">Назад</a>
		</div>
	</div>
</template>
<script>
	import {mapGetters, mapState, mapActions} from 'vuex';
	//import vSelect from 'vue-select';
	export default{
		name: 'ClaimSingleAdmin',
		components: {
			//vSelect
		},
		props: ['id'],
		data: ()=>({
			loading: false,
			singleClaim: {
				authorName: {
					lastname: '',
					firstName: '',
					patronymic: ''
				}
			},
			editing: false,
			statuses: [
				'Направлено',
				'В работе',
				'Отменено',
				'Выполнено',
				'Получено'
			]
		}),
		computed: {
			status: function(){
				return {
				  sended: this.singleClaim.status === 'Направлено',
				  inwork: this.singleClaim.status === 'В работе',
				  canceled: this.singleClaim.status === 'Отменено',
				  done: this.singleClaim.status === 'Выполнено'
				}
			},
			...mapGetters(['getClaim'])
			
		},
		methods: {
			...mapActions(['fetchAllClaims', 'updateClaim']),
			selectStatusHandler(event){
				this.singleClaim.status = event.target.value;
				this.updateClaim(this.singleClaim);
			}
		},
		mounted(){
			this.loading = true;
			//console.log(this.id);
			this.fetchAllClaims()
				.then(
					claims => {
						this.loading = false;
						this. singleClaim = this.getClaim(+this.id);
					}
				)
		},
	}
</script>
<style scoped lang="sass">
	.linkable
		text-decoration: underline
		color: blue
	.linkable:hover
		cursor: pointer
		color: red
	.claims
		width: 100%
	.claim_container
		flex-direction: column
		align-items: flex-start
		padding: 41px 0 0 0
		width: 100%
		font-size: 18px
		color: #000000
	.row_header
		padding: 0 40px 0 0
	.claim_row
		margin: 10px 0
	.sended
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		background: #EFEFEF
		border-radius: 10px
		text-align: center
		line-height: 25px
		padding: 3px 12px
		font-size: 16px
		color: #929292
	.inwork
		background: #E2EDFA
		border-radius: 10px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
	.canceled
		background: #FFE2E1
		border-radius: 10px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
	.done
		background: #EBF4E8
		border-radius: 10px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
</style>