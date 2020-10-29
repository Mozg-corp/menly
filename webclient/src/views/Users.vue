<template>
	<main >
		<div class="container_my content">
			<div v-if="isAuthenticated && isAdmin" class="main_box">
				<div class="table">
					<div class="thead">
						<div class="cell">
							user.id
						</div>
						<div class="cell">
							user.status
						</div>
						<div class="cell">
							login
						</div>
						<div class="cell">
							profile
						</div>
						<div class="cell">
							agregators
						</div>
						<div class="cell">
							Создан
						</div>
						<div class="cell cell_centered">
							Удалить
						</div>
					</div>
					<div class="row" v-for="user in users" :key="user.id">
						<div class="cell">
							{{user.id}}
						</div>
						<div class="cell">
							<select @change="changeUserStatusHandler($event, user.id)">
								<option v-for="status in statuses" :selected="status === statuses[user.status]">
									{{status}}
								</option>
							</select>
						</div>
						<div class="cell">
							{{user.phone}}
						</div>
						<div class="cell">
							{{user.profile && user.profile.lastname}} {{user.profile && user.profile.firstname}} {{user.profile && user.profile.secondname}}
						</div>
						<div class="cell">
							<ul>
								<li v-for="agregator in user.agregators" :key="agregator.id">
									{{agregator.name}}
								</li>
							</ul>
						</div>
						<div class="cell">
							{{user.create_at}}
						</div>
						<div class="cell cell_centered">
							<a href="#" @click.prevent="deleteUserHandler(user.id)">
								<b>[Х]</b>
							</a>
						</div>
					</div>
				</div><!--Table-->
				
			</div><!--main_box-->
			
			<div v-else>
				Нужно зайти под админом 79251234567
			</div>
			<div>
				<a class="link link__pagination"v-for="link in links" href="#" @click.prevent="paginatorHandler(link)">{{link}}</a>
			</div>
		</div><!--container-->
	</main> <!--main-->
</template>

<script>
// @ is an alias to /src
import {mapGetters, mapActions, mapState} from 'vuex';
export default {
  name: 'users',
  data: ()=> ({
	statuses: [
		'Not Active',
		'Candidate',
		'User'
	],
	links: []
  }),
  components: {
  },
  computed: {
	...mapState(['agregators_list', 'user', 'users', 'balances', 'isAuthenticated']),
	...mapGetters(['isAdmin', 'isAuthenticated']),
  },
  methods:{
	...mapActions(['fetchAllUsers', 'changeUserState', 'deleteUser', 'fetchUsersPage']),
	changeUserStatusHandler($event, userId){
		let statusName = $event.target.value;
		let status = this.statuses.findIndex( el => el === statusName)
		
		this.changeUserState({userId, status});
	},
	deleteUserHandler(userId){
		this.deleteUser(userId)
	},
	paginatorHandler(link){
		this.fetchAllUsers(link)
	}
  },
  
  mounted(){
	this.fetchAllUsers(1)
		.then(
			({pagination}) => {
				console.log(pagination)
				let {page_count, current_page} = pagination;
				this.links.push(1)
				for(let i=2; i<page_count; ++i){
					if(i<current_page+2 || i > current_page-2 || i>page_count-4){
						this.links.push(i)
					}
				}
				this.links.push(page_count);
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
	.row
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
		
</styles>