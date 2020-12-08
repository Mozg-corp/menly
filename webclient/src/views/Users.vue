<template>
	<b-container class="pt-4">
		<div v-if="isAuthenticated && isAdmin" class="main_box">
			<b-row 
				v-if="loadingAllUsers"
				align-h="center"
			>
				<b-spinner
					variant="dark"
					type="grow"
				  ></b-spinner>
			</b-row>
			<div v-else class="table">
				<div class="thead_r">
					<div class="cell">
						user.id
					</div>
					<div class="cell">
						user.status <br/>
						<select @change="changeUserStatusFilterHandler($event)">
							<option v-for="(status, i) in filterStatuses" :selected="selectedFilterStatus === status? 'selected':''">
								{{status}}
							</option>
						</select>
					</div>
					<div class="cell">
						login <br/>
						<input 
							v-model="loginFilter"
							@change="loginFilterHandler"
							class="input_loginFilter"
						/>
					</div>
					<div class="cell">
						profile <br/>
						<input 
							v-model="fioFilter"
							@change="fioFilterHandler"
							class="input_fioFilter"
						/>
					</div>
					<div class="cell">
						agregators
					</div>
					<div class="cell">
						Создан
						<b-icon-arrow-up-square class="mr-1 ml-1 sortAsc"
							@click="sortAscFilterHandler"
						></b-icon-arrow-up-square>
						<b-icon-arrow-down-square
							@click="sortDescFilterHandler"
							class="sortDesc"
						></b-icon-arrow-down-square>
						<b-icon-x-circle
							@click="undoSortFilterHandler"
							class="undoSort ml-1"
						></b-icon-x-circle>
					</div>
					<div class="cell cell_centered">
						Удалить
					</div>
				</div><!--thead-->
				<div 
					class="row_r" 
					v-for="user in users" 
					:key="user.id"
				>
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
				</div><!--row-->
			</div><!--Table-->
			
		</div><!--main_box-->
		
		<div v-else>
			Нужно зайти под админом 79251234567
		</div>
		<div>
			<a 
				:class="[{activePaginationLink: currentPage === link? true:false}, 'link_r', 'link__pagination']" 
				v-for="link in links" 
				href="#" 
				@click.prevent="paginatorHandler(link)"
			>
				{{link}}
			</a>
		</div>
	</b-container>
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
	filterStatuses: [
		'Все',
		'Not Active',
		'Candidate',
		'User'
	],
	filterStatusDecoder: {
		'Все': null,
		'Candidate': 1,
		'User': 2
	},
	selectedFilterStatus: 'Все',
	links: [],
	currentPage: 1,
	loginFilter: '',
	fioFilter: '',
	sort: null
  }),
  components: {
  },
  computed: {
	...mapState([
		'agregators_list', 
		'user', 
		'users', 
		'balances', 
		'isAuthenticated',
		'loadingAllUsers'
	]),
	...mapGetters(['isAdmin', 'isAuthenticated']),
	filterOptions(){
		return {
			status: this.filterStatusDecoder[this.selectedFilterStatus],
			login: this.loginFilter,
			fio: this.fioFilter,
			sort: this.sort
		};
	}
  },
  methods:{
	...mapActions([
		'fetchAllUsers', 
		'changeUserState', 
		'deleteUser', 
		'fetchUsersPage'
	]),
	changeUserStatusHandler($event, userId){
		let statusName = $event.target.value;
		let status = this.statuses.findIndex( el => el === statusName)
		
		this.changeUserState({userId, status});
	},
	deleteUserHandler(userId){
		this.deleteUser(userId)
	},
	paginatorHandler(link){
		if(link !== this.currentPage){
			this.fetchAllUsers({
				...this.filterOptions, 
				page:link
			}).then( 
					({pagination}) => {
						this.currentPage = link;
						let {page_count, current_page} = pagination;
						this.links = [];
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
	},
	changeUserStatusFilterHandler($event){
		this.selectedFilterStatus = $event.target.value;
		this.fetchAllUsers(this.filterOptions)
			.then(
				({pagination}) => {
					this.makePaginationLinks(pagination);
				}
			)
	},
	loginFilterHandler(){
		if(this.loginFilter.length>=2){
			this.fetchAllUsers(this.filterOptions).then(
			({pagination}) => {
				this.makePaginationLinks(pagination);
			}
		);
		}
	},
	fioFilterHandler(){
		if(this.fioFilter.length>2){
			this.fetchAllUsers(this.filterOptions);
		}
	},
	sortAscFilterHandler(){
		this.sort = 'create_at';
		this.fetchAllUsers(this.filterOptions)
			.then(
				(pagination) => {
					this.makePaginationLinks(pagination);
				}
			);
	},
	sortDescFilterHandler(){
		this.sort = '-create_at';
		this.fetchAllUsers(this.filterOptions)
			.then(
				(pagination) => {
					this.makePaginationLinks(pagination);
				}
			);
	},
	undoSortFilterHandler(){
		this.sort = null;
		this.fetchAllUsers(this.filterOptions)
			.then(
				(pagination) => {
					this.makePaginationLinks(pagination);
				}
			);
	},
	makePaginationLinks(pagination){
		let {page_count, current_page} = pagination;
		this.links = [];
		this.links.push(1)
		for(let i=2; i<page_count; ++i){
			if(i<current_page+2 || i > current_page-2 || i>page_count-4){
				this.links.push(i)
			}
		}
		this.links.push(page_count);
	}
  },
  
  mounted(){
	this.fetchAllUsers(this.filterOptions)
		.then(
			({pagination}) => {
				this.makePaginationLinks(pagination);
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
		width: 100%
	.row_r:hover
		background-color: grey
		color: white
	.cell
		display: table-cell
		padding: 7px 10px
		border: 0.5px solid black
	.cell_centered
		text-align: center
	.thead_r	
		display: table-header-group
		background-color: grey
		opacity: 0.3
		color: white
	.activePaginationLink
		color: black
		font-weight: 600
		border-bottom: 1px solid black
	.link_r
		color: cbd3d6
		&__pagination
			margin: 3px 2px
	.link_r:hover
		color: #01B6E7
		font-weight: 600
	.input_loginFilter
		width: 80px
	.input_fioFilter
		width: 120px
	.sortAsc:hover, .sortDesc:hover, .undoSort:hover
		background-color: #01B6E7
</styles>