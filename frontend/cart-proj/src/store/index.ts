import { createApp } from "vue";
import { createStore } from "vuex";

// Create a new store instance.
const store = createStore({
	actions: {
		updateIsValid({ commit }: { commit: Commit }, arr) {
			commit("addValidationField", arr);
		},
	},
	getters: {
		getValidState(state) {
			return state.isValid;
		},
		getIsValid: (state) => (name) => state.fieldValidationObject[name],
		getIs: (state) => state.fieldValidationObject,
	},
	state() {
		return {
			fieldValidationObject: {},
			isValid: null,
		};
	},
	mutations: {
		changeValidState(state, payload: boolean) {
			state.isValid = payload;
		},
		addValidationField(state, arr) {
			const [name, isValid] = arr;
			console.log(name, isValid);

			state.fieldValidationObject[name] = isValid;
		},
	},
});

export default store;
