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
							username = data.phone;
						localStorage.setItem('user-token', token); // store the token in localstorage
						localStorage.setItem('user-username', username);
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
		console.log(body);
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
	fetchAllClaims: ({commit, dispatch,getters}) => {
			return new Promise(
				async (resolve, reject) => {
					let url = `/api/v1/appeals/all`;
					//console.log(url)
					let response =  await axios({
						method: 'get',
						url
					})
					let claims = response.data;
					console.log(response);
					commit('SET_CLAIMS', claims);
					resolve(claims);
				}
			)
	},
	fetchCounters: ({commit, dispatch, getters}) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: '/api/v1/meters',
				})
				let counters = response.data;
				commit('SET_COUNTERS', counters);
				resolve(counters);
			}
		);
	},
	fetchContact: ({commit, dispatch, getters}) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: '/api/v1/information/contacts'
				})
				let contact = response.data;
				commit('SET_CONTACT', contact);
				resolve(contact);
			}
		)
	},
	fetchNews: ({commit, dispatch, getters}) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: '/api/v1/news/relevant'
				})
				let news = response.data;
				commit('SET_NEWS', news);
				resolve(news);
			}
		)
	},
	createNews: ({commit, dispatch, getters}, news) => {
		return new Promise(
			async (resolve, reject) => {
					let response = await axios({
						method: 'post',
						url: '/api/v1/news',
						data: news
					})
					let addedNews = response.data;
					dispatch('fetchNews');
					resolve(addedNews);
			}
		)
	},
	updateNews: ({commit, dispatch, getters}, news) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: `/api/v1/news/${news.id}`,
					data: news
				})
				let updatedNews = response.data;
				dispatch('fetchNews');
				resolve(updatedNews);
			}
		)
	},
	fetchClaims: ({commit, dispatch, getters}) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: '/api/v1/appeals'
				})
				let claims = response.data;
				commit('SET_CLAIMS', claims);
				resolve(claims);
			}
		)
	},
	createClaim: ({commit, dispatch, getters}, newClaim) =>{
		return new Promise(
			async (resolve,reject) => {
				let response;
				try{
					response = await axios({
						method: 'post',
						url: '/api/v1/appeals',
						data: newClaim
					})
				}catch(e){
					reject(e);
				}
				if(response.status === 200){
					resolve();
				}else{
					reject(response)
				}
			}
		)
	},
	sendIndication: ({commit, dispatch, getters}, {id, value, isAdmin = false}) => {
		//console.log(id, value)
		// console.log(isAdmin)
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: `/api/v1/meters/${id}/data`,
					params: {
					  submitData: value
					}
				})
				if(response.status === 200){
					if(isAdmin){
						// dispatch('fetchAllMeters')
							// .then(
								// d => resolve(d)
							// )
					}else{
						dispatch('fetchCounters')
						.then(
							d => resolve(d)					
						)
					}
				}else{
					reject(response)
				}
			}
		)
	},
	createNewContactField: ({commit, dispatch}, newField) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: '/api/v1/information/contacts',
					data: newField
				})
				if(response.status === 200){
					dispatch('fetchContact')
						.then(
							d => resolve()					
						)
				}else{
					reject(response)
				}
			}
		)
	},
	fetchRequisites: ({commit, dispatch}) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: '/api/v1/management/requisites'
				})
				console.log(response)
				if(response.status === 200){
					let requisites = response.data;
					commit('SET_REQUISITES', requisites);
					resolve(requisites)
				}else{
					reject(response)
				}
			}
		)
	},
	fetchCityzens: ({commit, dispatch}) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: '/api/v1/management/users'
				})
				if(response.status === 200){
					let cityzens = response.data;
					commit('SET_CITYZENS', cityzens);
					resolve(cityzens)
				}else{
					reject(response)
				}
			}
		)
	},
	fetchAllMeters: ({commit, dispatch}) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: '/api/v1/meters/all'
				})
				if(response.status === 200){
					let meters = response.data;
					commit('SET_METERS', meters);
					resolve(meters);
				}else{
					reject(response)
				}
				
			}
		)
	},
	fetchSingleMeter: ({commit, dispatch}, id) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: `/api/v1/meters/${id}`
				})
				if(response.status === 200){
					let meter = response.data
					commit('SET_SINGLE_METER', meter);
					resolve(meter);
				}else{
					reject(response)
				}
			}
		)
	},
	fetchAllSingleMeterIndications: ({commit, dispatch}, id) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'get',
					url: `/api/v1/meters/${id}/data`
				})
				if(response.status === 200){
					let data = response.data;
					commit('SET_ALL_SINGLE_METER_INDICATION', data);
					resolve(data)
				}else{
					reject(response)
				}
			}
		)
	},
	updateClaim: ({commit, dispatch}, updatedClaim) => {
		//commit('UPDATE_CLAIM', updatedClaim);
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: `/api/v1/appeals/${updatedClaim.id}`,
					data: updatedClaim
				})
				if(response.status === 200){
					let claim = response.data;
					commit('UPDATE_CLAIM', claim);
					resolve(claim);
				}else{
					reject(response);
				}
			}
			
		)
	},
	updateMetersBatch: ({commit, dispatch}, metersData) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: '/api/v1/meters/all/data',
					data: metersData
				})
				if(response.status === 200){
					dispatch('fetchAllMeters')
						.then(
							r => resolve(r)
						)
					
				}else{
					reject(response)
				}
			}
		)
	},
	createNewCounter: ({commit, dispatch}, newCounter) => {
		console.log(newCounter)
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: '/api/v1/meters',
					data: newCounter
				})
				console.log(response)
				if(response.status === 200){
					let counter = response.data;
					commit('ADD_NEW_COUNTER', counter);
					resolve(counter);
				}else{
					reject(response)
				}
			}
		)
	},
	updateCounterDescription: ({commit, dispatch}, updatedCounter) =>{
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'put',
					url: '/api/v1/meters',
					data: updatedCounter,
				})
				if(response.status === 200){
					let meter = response.data;
					commit('SET_SINGLE_METER', meter);
					resolve(meter);
				}else{
					reject(response);
				}
			}
		)
	},
	changePassword: ({commit, dispatch}, auth) => {
		//console.log(auth);
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: '/api/v1/profile/update/password',
					data: auth
				})
				if(response.status === 200){
					resolve()
				}else{
					reject(response)
				}
			}
		)
	},
	changeContactField: ({commit, dispatch}, field) => {
		return new Promise(
			async (resolve, reject) => {
				let response = await axios({
					method: 'post',
					url: `/api/v1/information/contacts/${field.id}`,
					data: field
				})
				if(response.status === 200){
					let updatedField = response.data;
					commit('UPDATE_CONTACT_FIELD', updatedField);
					resolve(updatedField)
				}else{
					reject(response)
				}
			}
		)
	}
}