import axios from 'axios';
import router from "../router";
export default {
	signIn: ({commit, dispatch, getters}, bodyFormData)=>{
		dispatch('logout');
		return  axios({
				method: 'post',
				url: '/auth/sign-in',
				data: bodyFormData,
				headers: {'Content-Type': 'multipart/form-data' }
			}).then(response => {
				console.log(response);
				if (response.data !== ''){
					let data = response.data;
						let token = data.token,
							username = data.phone,
							userId = data.id;
						localStorage.setItem('user-token', token); // store the token in localstorage
						localStorage.setItem('user-username', username);
						localStorage.setItem('user-id', userId);
						let isAdmin = data.roles.includes('admin');
						localStorage.setItem('user-isAdmin', isAdmin);
						//console.log('auth_action',isAdmin);						
						axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
						commit('AUTH_SUCCESS', {token, isAdmin, username, userId});
						commit('SET_USER', data);
				}
			}).catch(e =>{
				console.log(e);
				commit('AUTH_ERROR', ',eh ,eh');
				localStorage.removeItem('user-token'); // if the request fails, remove any possible user token if possible
				localStorage.removeItem('user-isAdmin');
				localStorage.removeItem('user-username');
				localStorage.removeItem('user-id');
			});
	},
	signUp: ({commit, dispatch, getters}, bodyFormData)=>{
		return  axios({
				method: 'post',
				url: '/auth/sign-up',
				data: bodyFormData,
				headers: {'Content-Type': 'multipart/form-data' }
			}).then(response => {
				console.log(response);
				if (response.data !== ''){
					let data = response.data;
						let token = data.token,
							username = data.phone,
							userId = data.id;
						localStorage.setItem('user-token', token); // store the token in localstorage
						localStorage.setItem('user-username', username);
						localStorage.setItem('user-id', userId);
						let isAdmin = data.roles.includes('admin');
						localStorage.setItem('user-isAdmin', isAdmin);
						//console.log('auth_action',isAdmin);						
						axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
						commit('AUTH_SUCCESS', {token, isAdmin, username});
						commit('SET_USER', data);
				}
			}).catch(e =>{
				console.log(e);
				commit('AUTH_ERROR', ',eh ,eh');
				localStorage.removeItem('user-token'); // if the request fails, remove any possible user token if possible
				localStorage.removeItem('user-isAdmin');
				localStorage.removeItem('user-username');
				localStorage.removeItem('user-id');
			});
	},
	logout({commit, dispatch}) {
		return new Promise((resolve, reject)=>{
			commit('LOGOUT');
			localStorage.removeItem('user-token');
			localStorage.removeItem('user-isAdmin');
			localStorage.removeItem('user-username');
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
				agregators_id: +el
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
				}catch(e){
					console.log(e.response.data.message)
				}
				if(response && response.status === 201){
					let userAgregators = response.data;
					commit('SET_USER_AGREGATORS', userAgregators)
					resolve(userAgregators);
				}else{
					reject(response?response:'')
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
				//console.log(userData)
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
					let profile = response.data;
					commit('SET_PROFILE', profile);
					resolve(profile);
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
					let car = response.data;
					commit('SET_CAR', car);
					resolve(car);
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
					let response = await axios({
						method: 'get',
						url: `/api/v1/balances/${userId}`
					})
					let balances = response.data;
					commit('SET_BALANCES', balances);
					resolve(balances);
				}catch(e){
					console.log(e.response);
					reject(e.response)
				}
			}
		)
	},
	fetchAllUsers: ({commit}, page) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: `/api/v1/users?page=${page}`
				})
				let users = response.data;
				console.log(response.headers)
				let pagination = {
					current_page: +response.headers['x-pagination-current-page'],
					page_count: +response.headers['x-pagination-page-count'],
					per_page: +response.headers['x-pagination-per-page'],
					total_count: +response.headers['x-pagination-total-count']
				}
				commit('SET_USERS', users);
				resolve({users, pagination});
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
				console.log(response)
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
	}
}