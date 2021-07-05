import { createStore, createLogger } from "vuex";
import { State, Property } from "../interfaces";
import { LOAD_PROPERTIES, AUTH } from "./action-types";

import {
  SET_VIEWING,
  ADD_PROPERTY,
  REMOVE_PROPERTY,
  SET_BUYING_FLAG,
  TOGGLE_INTERESTED,
  OPEN_MODAL,
  CLOSE_MODAL,
  SET_AUTH,
} from "./mutation-types";

function timeout(ms: number) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}
export default createStore({
  state: (): State => ({
    list: [],
    viewing: -1,
    interested: [],
    buying: true,
    formModal: false,
    authenticated: false,
  }),
  mutations: {
    [ADD_PROPERTY](state: State, property: Property) {
      state.list.push(property);
    },
    [REMOVE_PROPERTY](state: State, property: Property) {
      state.list.splice(state.list.indexOf(property), 1);
    },
    [SET_VIEWING](state: State, id: number) {
      state.viewing = id;
    },
    [SET_BUYING_FLAG](state: State, flag: boolean) {
      state.buying = flag;
    },
    [SET_AUTH](state: State, flag: boolean) {
      state.authenticated = flag;
    },
    [TOGGLE_INTERESTED](state: State, id: number) {
      const property = state.list.find(
        (property: Property) => property.id === id
      );
      if (property) {
        property.interested = !property.interested;
      }
    },
    [CLOSE_MODAL](state: State) {
      state.formModal = false;
    },
    [OPEN_MODAL](state: State) {
      state.formModal = true;
    },
    clear(state: State) {
      state.list = [];
      state.viewing = -1;
      state.interested = [];
      state.buying = false;
    },
  },
  getters: {
    getPropertyById: (state: State) => (id: number) => {
      return state.list.find((property) => property.id === id);
    },
    getCurrentViewingProperty: (state: State) => {
      if (state.viewing >= 0) {
        return state.list.find((property) => property.id === state.viewing);
      } else {
        return state.list[0];
      }
    },
    getProperties: (state: State) => () => {
      return state.list.filter(
        (property: Property) => property.buying === state.buying
      );
    },
    isBuying: (state: State) => () => state.buying,
  },
  actions: {
    // eslint-disable-next-line  @typescript-eslint/no-explicit-any
    async [LOAD_PROPERTIES](ctx: any) {
      ctx.commit("clear");
      const data = await fetch("data.json");
      data
        .json()
        .then((jsonData) => {
          jsonData.properties.forEach((property: Property) =>
            ctx.commit(ADD_PROPERTY, property)
          );
        })
        .then(() => {
          if (ctx.state.list.length > 0) {
            ctx.commit(SET_VIEWING, ctx.state.list[0].id);
          }
        });
    },
    async [AUTH](ctx: any, login: boolean) {
      await timeout(1000);
      ctx.commit(SET_AUTH, login);
    },
  },
  modules: {},
  plugins: process.env.NODE_ENV !== "production" ? [createLogger()] : [],
});
