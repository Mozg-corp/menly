let initState = {
	userId: '',
	token: '',
	status: '',
	errorMsg: '',
	admin: false,
	username: '',
	agregators_list: [],
	user: [],
	users: [],
	balances: [],
	userStatuses: [
		'Not Active',
		'Candidate',
		'User'
	],
	transactions: [],
	transfers: []
}
export default {
	AUTH_REQUEST: (state) => {

		state.status = 'loading'
	},

	AUTH_SUCCESS: (state, {token, isAdmin, username, userId}) => {
		state.admin = isAdmin;
		state.status = 'success';
		state.token = token;
		state.username = username;
		state.userId = userId

	},

	AUTH_ERROR: (state, msg) => {

		state.status = 'error';
		state.errorMsg = msg;
		state.token = '';

	},

	LOGOUT: (state) => {
		for(let prop in initState){
			state[prop] = initState[prop];
		}
		state.userStatuses = [
			'Not Active',
			'Candidate',
			'User'
		]

	},
	SET_AGREGATORS_LIST: (state, list) => {
		state.agregators_list = list
	},
	SET_USER: (state, user) => {
		state.user = user
	},
	SET_USER_AGREGATORS: (state, userAgregators) => {
		state.user.agregators = userAgregators
	},
	SET_PROFILE: (state, profile) => {
		state.user.profile = profile;
	},
	SET_CAR: (state, car) => {
		state.car = car
	},
	SET_BALANCES: (state, balances) => {
		state.balances = balances
	},
	SET_USERS: (state,users) => {
		state.users = users
	},
	UPDATE_USER_STATUS: (state, updatedUser) => {
		let index = state.users.findIndex( el => el.id === updatedUser.id);
		state.users[index] = updatedUser;
	},
	DELETE_USER: (state, id) => {
		let index = state.users.findIndex( el => el.id === id );
		state.users = [...state.users.slice(0, index), ...state.users.slice(index+1)]
	},
	SET_TRANSACTIONS: (state, transactions) => {
		state.transactions = transactions
	},
	CHANGE_BALANCE: (state, newBalance) => {
		let oldBalance = parseFloat(state.balances[newBalance.agregatorName]);
		let updatedBalance = oldBalance + parseFloat(newBalance.balance);
		state.balances[newBalance.agregatorName] = updatedBalance;
	},
	SET_USER_TRANSFERS: (state, transfers) => {
		state.transfers = transfers
	}
}