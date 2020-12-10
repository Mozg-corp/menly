<template>
	<b-container>
			<div v-if="isAuthenticated && isAdmin" class="main_box">
				<div class="table">
					<div class="thead">
						<div class="cell">
							дата
						</div>
						<div class="cell">
							Пользователь
						</div>
						<div class="cell">
							login
						</div>
						<div class="cell">
							агрегатор
						</div>
						<div class="cell">
							сумма перевода
						</div>
						<div class="cell">
							статус перевода
						</div>
						<div class="cell">
							комментарий
						</div>
						<div class="cell">
							действия
						</div>
					</div>
					<div class="row_r" v-for="transfer in allTransfers" :key="transfer.created_at">
						<div class="cell">
							{{transfer.created_at}}
						</div>
						<div class="cell">
							{{transfer.users.profile.fio}}
						</div>
						<div class="cell">
							{{transfer.users.phone}}
						</div>
						<div class="cell">
							{{transfer.agregators.name}}
						</div>
						<div class="cell cell_centered">
							{{transfer.transfer}}
						</div>
						<div class="cell">
							{{transfer.transferStatuses.status}}
						</div>
						<div class="cell cell_centered">
							{{transfer.description}}
							<p v-show="transfer.agregator_transfer_id && transfer.agregator_transfer_id.length">
								id: {{transfer.agregator_transfer_id}}
							</p>
						</div>
						<div class="cell cell_centered">
							<ul>
								<li 
									v-if="transfer.transferStatuses.status === 'Создан'"
									class="transfer_action"
								>
									<a href="#" @click.prevent="createAgregatorTransactionHandler(transfer.id)" >
										Списать
									</a>
								</li>
								<li 
									v-if="transfer.transferStatuses.status === 'Списано'"
									class="transfer_action"
								>
									<a href="#" @click.prevent="createBankTransferHandler(transfer.id)" >
										Перевести
									</a>
								</li>
								<li 
									v-if="transfer.transferStatuses.status !== 'Переведено'"
									class="transfer_action"
								>
									<a href="#" @click.prevent="cancelAgregatorTransfer()">
										Отклонить
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div><!--Table-->
				
			</div><!--main_box-->
			
			<div v-else>
				Нужно зайти под админом 79251234567
			</div>
			<div>
				<!--<a class="link link__pagination"v-for="link in links" href="#" @click.prevent="paginatorHandler(link)">{{link}}</a>-->
			</div>
	</b-container>
</template>

<script>
// @ is an alias to /src
import {mapGetters, mapActions, mapState, mapMutations} from 'vuex';
export default {
  name: 'transfers',
  data: ()=> ({
	links: []
  }),
  components: {
  },
  computed: {
	...mapState(['allTransfers', 'isAuthenticated']),
	...mapGetters(['isAdmin', 'isAuthenticated']),
  },
  methods:{
	...mapActions([
		'fetchAllTransfers', 
		'createAgregatorTransaction',
		'createBankTransfer'
	]),
	...mapMutations(['SET_TRANSFER_DEBIT']),
	paginatorHandler(link){
		//this.fetchAllUsers(link)
	},
	createAgregatorTransactionHandler(transferId){
		this.createAgregatorTransaction(transferId)
			.then(
				transferResult=> {
					this.SET_TRANSFER_DEBIT(transferResult);
				}
			)
	},
	createBankTransferHandler(transferId){
		this.createBankTransfer(transferId)
			.then(
				() => {
					this.fetchAllTransfers();
				}
			)
	},
	cancelAgregatorTransfer(){
	
	}
  },
  
  mounted(){
	this.fetchAllTransfers(1)
		.then(
			({pagination}) => {
				/*
				console.log(pagination)
				let {page_count, current_page} = pagination;
				this.links.push(1)
				for(let i=2; i<page_count; ++i){
					if(i<current_page+2 || i > current_page-2 || i>page_count-4){
						this.links.push(i)
					}
				}
				this.links.push(page_count);
				*/
			}
		)
  }
}
</script>
<styles scoped lang="sass">
	ul
		list-style-type: none
	.choose
		padding: 5px 30px
		background-color: #cbd3d6
	.passport_box
		max-width: 200px
		display: flex
		flex-direction: column
		justify-content: space-beetween
		margin: 30px 0
	input
		padding: 5px 10px
		margin: 5px 0
	.send_profile
		padding: 5px 30px
		background-color: #cbd3d6
	.property
		margin: 5px 0
	.main_box
	.right_side
		width: 50%
	.balance_row
		display: flex
		justify-content: space-between
		margin: 0 auto
		width: 100%
		border-bottom: 1px solid black
		margin: 5px 0
	.table	
		display: table
		width: 100%
		margin: 0 auto
	.row_r
		display: table-row
	.cell
		display: table-cell
		padding: 7px 10px
		border: 0.5px solid black
	.cell_centered
		text-align: center
	.thead	
		display: table-header-group
		background-color: grey
		opacity: 0.3
		color: white
	.link
		color: grey
		&__pagination
			margin: 3px 2px
	.link:hover
		color: blue
	.transfer_action
		border: 1px solid black
		margin: 2px 0
		
</styles>