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

		state.status = '';
		state.token = '';
		state.username = '';
		state.admin = false;

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
		state.profile = profile;
	},
	SET_CAR: (state, car) => {
		state.car = car
	},
	SET_BALANCES: (state, balances) => {
		state.balances = balances
	},
	SET_COUNTERS: (state, counters) => {
		state.counters = counters;
	},
	SET_CONTACT: (state, contact) => {
		state.contact = contact
	},
	SET_NEWS: (state, news) => {
		state.news = news
	},
	SET_CLAIMS: (state, claims) => {
		state.claims = claims
	},
	SET_REQUISITES: (state, requisites) => {
		state.requisites = requisites
	},
	SET_CITYZENS: (state, cityzens) => {
		state.cityzens = cityzens
	},
	SET_METERS: (state, meters) => {
		state.meters = meters
	},
	SET_SINGLE_METER: (state, meter) => {
		state.singleMeter = meter
	},
	SET_ALL_SINGLE_METER_INDICATION: (state, data) => {
		state.singleMeterAllIndications = data
	},
	UPDATE_CLAIM: (state, updatedClaim) => {
		// console.log(state.claims.findIndex(el=>el.id === updatedClaim.id))
		let claimIndex = state.claims.findIndex(el=>el.id === updatedClaim.id);
		//state.claims = [...state.claims.slice(0,claimIndex), updatedClaim, ...state.claims.slice(claimIndex + 1)]
		state.claims[claimIndex] = updatedClaim;
	},
	ADD_NEW_COUNTER: (state, counter) => {
		state.meters = [...state.meters, counter]
	},
	UPDATE_CONTACT_FIELD: (state, updatedField) => {
		let fieldIndex = state.contact.findIndex(el=>el.id === updatedField.id);
		state.contact[fieldIndex] = updatedField
	}
}