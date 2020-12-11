let initState = {
	userId: '',
	token: '',
	status: '',
	errorMsg: '',
	admin: false,
	username: '',
	agregators_list: [],
	user: [],
	singleUser: {},
	users: [],
	balances: [],
	userStatuses: [
		'Not Active',
		'Candidate',
		'User'
	],
	transactions: [],
	transfers: [],
	allTransfers: [],
	userChooseAgregator: false,
	userHasCarData: false,
	userHasProfileData: false,
	loadingUserData: false,
	loadingBalances: false,
	loadingTransfers: false,
	loadingAllUsers: false,
	loadingUser: false,
	loadingDriverAccounts: false,
	loadingAllTransfers: false
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
		state.userChooseAgregator = true
	},
	SET_PROFILE: (state, profile) => {
		state.user.profile = profile;
		state.userHasProfileData = true;
	},
	SET_CAR: (state, car) => {
		state.car = car
		state.userHasCarData = true;
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
	},
	SET_TRANSFERS: (state, transfers) => {
		state.allTransfers = transfers
	},
	SET_TRANSFER_DEBIT: (state, {id, agregator_transfer_id, description}) => {
		let index = state.allTransfers.findIndex( el => el.id === parseInt(id));
		state.allTransfers[index].transferStatuses.status = "Списано";
		state.allTransfers[index].agregator_transfer_id = agregator_transfer_id;
		state.allTransfers[index].description = description;
	},
	SET_LOADING_USER_DATA_STATE: (state, loadingState) => {
		state.loadingUserData = loadingState
	},
	SET_LOADING_BALANCE_STATE: (state, loadingState) => {
		state.loadingBalances = loadingState
	},
	SET_LOADING_TRANSFERS_STATE: (state, loadingState) => {
		state.loadingTransfers = loadingState
	},
	SET_USER_CHOOSE_AGREGATOR: (state, stateValue) => {
		state.userChooseAgregator = stateValue
	},
	SET_USER_HAS_PROFILE_DATA: (state, stateValue) => {
		state.userHasProfileData = stateValue
	},
	SET_USER_HAS_CAR_DATA: (state, stateValue) => {
		state.userHasCarData = stateValue
	},
	SET_ALL_USERS_LOADING_STATE: (state, stateValue) => {
		state.loadingAllUsers = stateValue
	},
	SET_USER_LOADING_STATE: (state, stateValue) => {
		state.loadingUser = stateValue
	},
	SET_DRIVER_ACCOUNTS_LOADING_STATE: (state, stateValue) => {
		state.loadingDriverAccounts = stateValue
	},
	SET_SINGLE_USER: (state, user) => {
		state.singleUser = user
	},
	SET_ALL_TRANSFERS_LOADING_STATE: (state, stateValue) => {
		state.loadingAllTransfers = stateValue
	}
}