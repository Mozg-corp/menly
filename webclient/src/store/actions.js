import axios from 'axios';
import router from "../router";
export default {
	signIn: ({commit, dispatch, getters}, bodyFormData)=>{
		dispatch('logout');
		return  new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'post',
						url: '/auth/sign-in',
						data: bodyFormData,
						headers: {'Content-Type': 'multipart/form-data' }
					});
					console.log(response);
					if (response.data && response.data.success){
						let data = response.data.user;
						let token = data.token,
							username = data.phone,
							userId = data.id;
						localStorage.setItem('user-token', token); // store the token in localstorage
						localStorage.setItem('user-username', username);
						localStorage.setItem('user-id', userId);
						let isAdmin = data.roles.includes('admin');
						localStorage.setItem('user-isAdmin', isAdmin);
						if(data.car){
							localStorage.setItem('userHasCarData', true);
							commit('SET_USER_HAS_CAR_DATA', true);
						}else{
							localStorage.setItem('userHasCarData', false);
						}
						if(data.profile){
							localStorage.setItem('userHasProfileData', true);
							commit('SET_USER_HAS_PROFILE_DATA', true);
						}else{
							localStorage.setItem('userHasProfileData', false);
						}
						console.log('gggg',data.agregators.length);
						if(data.agregators.length){
							localStorage.setItem('userChooseAgregator', true);
							commit('SET_USER_CHOOSE_AGREGATOR', true);
						}else{
							localStorage.setItem('userChooseAgregator', false);
						}
						console.log('auth_action',isAdmin);						
						axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
						commit('AUTH_SUCCESS', {token, isAdmin, username, userId});
						commit('SET_USER', data);
						resolve();
					}else{ 
						reject(response.data);
					}
				}catch(e){
					commit('AUTH_ERROR', ',eh ,eh');
					localStorage.removeItem('user-token'); // if the request fails, remove any possible user token if possible
					localStorage.removeItem('user-isAdmin');
					localStorage.removeItem('user-username');
					localStorage.removeItem('user-id');
					localStorage.removeItem('userHasCarData');
					localStorage.removeItem('userHasProfileData');
					localStorage.removeItem('userChooseAgregator');
					console.log(e);
					reject(e.response);
				}
			});
	},
	signUp: ({commit, dispatch, getters}, bodyFormData)=>{
		return  new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'post',
						url: '/auth/sign-up',
						data: bodyFormData,
						headers: {'Content-Type': 'multipart/form-data' }
					})
					if (response.data.success){
						let data = response.data.user;
							let token = data.token,
								username = data.phone,
								userId = data.id;
							localStorage.setItem('user-token', token); // store the token in localstorage
							localStorage.setItem('user-username', username);
							localStorage.setItem('user-id', userId);
							let isAdmin = data.roles.includes('admin');
							localStorage.setItem('user-isAdmin', isAdmin);				
							axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
							commit('AUTH_SUCCESS', {token, isAdmin, username, userId});
							commit('SET_USER', data);
							resolve(data);
					}else{
						let data = response.data;
						reject(data);
					}
				}catch(e){
					console.log(e);
					commit('AUTH_ERROR', ',eh ,eh');
					reject(e.response);
				}
			}
		);
	},
	logout({commit, dispatch}) {
		return new Promise((resolve, reject)=>{
			commit('LOGOUT');
			localStorage.removeItem('user-token');
			localStorage.removeItem('user-isAdmin');
			localStorage.removeItem('user-username');
			localStorage.removeItem('userChooseAgregator')
			localStorage.removeItem('userHasProfileData')
			localStorage.removeItem('userHasCarData')
			localStorage.removeItem('user-id');
			// remove the axios default header;
			delete axios.defaults.headers.common['Authorization'];
			resolve()
		})
	},
	fetchAgregatorsList: ({commit}) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: '/api/v1/agregators'
				})
				//console.log(response);
				if(response && response.status === 200){
					let agregators_list = response.data;
					commit('SET_AGREGATORS_LIST', agregators_list);
					resolve(agregators_list);
				}
			}
		)
	},
	postAgregators: ({commit, state}, selectedAgregators) => {
		let body = [];
		let users_id = state.user.id;
		selectedAgregators.forEach( el => {
			body.push({
				users_id,
				agregators_id: +el.id
			})
		})
		return new Promise(
			async (resolve, reject) => {
				let response = null;
				try{
					response = await axios({
						method: 'post',
						url: '/api/v1/user-agregator/batch',
						data: body
					})
					if(response && response.status === 201){
						let userAgregators = response.data;
						commit('SET_USER_AGREGATORS', userAgregators)
						localStorage.setItem('userChooseAgregator', true);
						resolve(userAgregators);
					}else{
						reject(response)
					}
				}catch(e){
					reject(e.response)
				}
			}
		)
	},
	fetchUserData: ({commit}, userId) =>{
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: `/api/v1/users/${userId}`
				})
				let userData = response.data;
				commit('SET_USER', userData);
				resolve(userData);
			}
		)
	},
	fetchProfile: ({commit, dispatch,getters}) => {
		return new Promise(
			async (resolve, reject) => {
				let response =  await axios({
					method: 'get',
					url: '/api/v1/profiles'
				})
				let profile = response.data;
				commit('SET_PROFILE', profile);
				resolve(profile);
			}
		)
	},
	createProfile: ({commit}, newProfile) => {
		return new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'post',
						url: '/api/v1/profiles',
						data: newProfile
					})
					console.log(response)
					if(response.status === 201){
						let profile = response.data;
						commit('SET_PROFILE', profile);
						localStorage.setItem('userHasProfileData', true);
						resolve(profile);
					}else{
						reject({
							succes: false,
							errors: response.data
						});
					}
				}catch(e){
					console.log(e.response.data.message)
					console.log(e.response);
				}
				
			}
		)
	},
	createCar: ({commit}, newCar) => {
		return new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'post',
						url: '/api/v1/cars',
						data: newCar
					})
					console.log(response)
					if(response.status === 201){
						let car = response.data;
						commit('SET_CAR', car);
						localStorage.setItem('userHasCarData', true);
						resolve(car);
					}else{
						reject({
							succes: false,
							errors: response.data
						});
					}
				}catch(e){
					console.log(e.response);
					reject(e.response)
				}
			}
		)
	},
	fetchBalances: ({commit}, userId) => {
		return new Promise(
			async (resolve, reject) => {
				try{
					commit('SET_LOADING_BALANCE_STATE', true);
					let response = await axios({
						method: 'get',
						url: `/api/v1/balances/${userId}`
					})
					let balances = response.data;
					commit('SET_BALANCES', balances);
					commit('SET_LOADING_BALANCE_STATE', false);
					resolve(balances);
				}catch(e){
					console.log(e.response);
					commit('SET_LOADING_BALANCE_STATE', false);
					reject(e.response)
				}
			}
		)
	},
	fetchAllUsers: ({commit}, {status, login, fio, sort, page=1}) => {
		let url = `/api/v1/users?page=${page}`;
		url = status == null||login == undefined?url:url+`&status=${status}`;
		url = login == ''?url:url+`&phone=${login}`;
		url = fio == ''?url:url+`&lastname=${fio}`;
		url = sort == null||sort == undefined?url:url+`&sort=${sort}`;
		console.log(login);
		console.log(fio);
		console.log(url);
		commit('SET_ALL_USERS_LOADING_STATE', true);
		return new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'get',
						url
					})
					if(response.status === 200){
						let users = response.data;
						let pagination = {
							current_page: +response.headers['x-pagination-current-page'],
							page_count: +response.headers['x-pagination-page-count'],
							per_page: +response.headers['x-pagination-per-page'],
							total_count: +response.headers['x-pagination-total-count']
						}
						commit('SET_USERS', users);
						commit('SET_ALL_USERS_LOADING_STATE', false);
						resolve({users, pagination});
					}else{
						commit('SET_ALL_USERS_LOADING_STATE', false);
						reject(response)
					}
				}catch(e){
					commit('SET_ALL_USERS_LOADING_STATE', false);
					reject(e.response);
				}
			}
		)
	},
	fetchUsersPage: ({commit}, url) => {
		return new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'get',
						url
					})
					let users = response.data;
					commit('SET_USERS', users);
					resolve(users);
				}catch(e){
					reject(e.response)
				}
			}
		)
	},
	changeUserState: ({commit}, {userId, status}) => {
		return new Promise(
			async (resolve, reject) =>{
				let response = null;
				try{
					response = await axios({
						method: 'put',
						url: `/api/v1/users/${userId}`,
						data: {status}
					})
				}catch(e){
					console.log(e);
					reject(e.response);
					return;
				}
				if(response && response.status === 200){
					let updatedUser = response.data;
					commit("UPDATE_USER_STATUS", updatedUser);
					resolve(updatedUser);
				}
			}
		)
	},
	deleteUser: ({commit}, id) => {
		return new Promise(
			async (resolve, reject) => {
				let response = null;
				try{
					let response = await axios({
						method: 'delete',
						url: `/api/v1/users/${id}`
					})
					if(response.status === 204){
						commit('DELETE_USER', id);
						resolve();
					}else{
						reject(response);
					}
				}catch(e){
					console.log(e);
					reject(e.response);
					return;
				}
				
			}
		)
	},
	fetchTransactions: ({commit}, userId) => {
		return new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'get',
						url: `/api/v1/transactions/${userId}`
					})
					if(response.status === 200){
						let transactions = response.data;
						commit('SET_TRANSACTIONS', transactions);
						resolve(transactions);
					}else{
						reject(response);
					}
				}catch(e){
					reject(e.response);
					return;
				}
			}
		)
	},
	transfer: ({}, transfer) => {
		//console.log(transfer)
		return new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'post',
						url: '/api/v1/transactions',
						data: transfer
					})
					if(response.status === 200){
						let result = response.data;
						resolve(result);
					}
				}catch(e){
					reject(e.response);
				}
			}
		)
	},
	createTransfer: ({}, transfer) => {
		return new Promise(
			async (resolve, reject) =>{
				try{
					let response = await axios({
						method: 'post',
						url: '/api/v1/transfers',
						data: transfer
					});
					console.log(response)
					if(response.status === 201){
						resolve();
					}else{
						reject(response);
					}
				}catch(e){
					reject(e.response);
				}
			}
		);
	},
	fetchUserTransfers: ({commit}) => {
		return new Promise(
			async (resolve, reject) => {
				commit('SET_LOADING_TRANSFERS_STATE', true);
				try{
					let response = await axios({
						method: 'get',
						url: '/api/v1/transfers/all',
					});
					if(response.status === 200){
						let transfers = response.data;
						commit('SET_USER_TRANSFERS', transfers);
						commit('SET_LOADING_TRANSFERS_STATE', false);
						resolve(transfers);
					}
				}catch(e){
					commit('SET_LOADING_TRANSFERS_STATE', false);
					reject(e);
				}
			}
		)
	},
	fetchAllTransfers: ({commit}) => {
		return new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'get',
						url: '/api/v1/transfers?expand=users&sort=-created_at'
					});
					if(response.status === 200){
						let transfers = response.data;
						commit('SET_TRANSFERS', transfers);
						
					}else{
						reject(response);
					}
				}catch(e){
					reject(e.response);
				}
			}
		);
	},
	createAgregatorTransaction: ({}, transfer_id) => {
		let body = {transfer_id};
		console.log(body);
		return new Promise(
			async (resolve, reject) => {
				try{
					let response = await axios({
						method: 'post',
						url: `/api/v1/transactions`,
						data: body
					});
					console.log(response);
					if(response.status === 201){
						let result = response.data;
						resolve(result);
					}else{
						reject(response);
					}
				}catch(e){
					reject(e.response);
				}
			}
		);
	},
	postTransfers: ({}, transfers) => {
		console.log(transfers)
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: '/api/v1/transfers/batch',
					data: transfers
				});
				console.log(response);
				resolve();
			}
		);
	}
}