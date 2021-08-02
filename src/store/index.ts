import { createStore, createLogger, ActionContext } from "vuex";
import { State, Property } from "../interfaces";
import { LOAD_PROPERTIES, AUTH } from "./action-types";

import {
  SET_VIEWING,
  ADD_PROPERTY,
  REMOVE_PROPERTY,
  SET_BUYING_FLAG,
  TOGGLE_INTERESTED,
  SET_AUTH,
} from "./mutation-types";

function timeout(ms: number) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}
export default createStore({
  state: (): State => ({
    list: [],
    properties: [],
    viewing: -1,
    interested: [],
    buying: true,
    authenticated: false,
  }),
  mutations: {},
  getters: {},
  actions: {
    // eslint-disable-next-line  @typescript-eslint/no-explicit-any
  },
  modules: {},
  plugins: process.env.NODE_ENV !== "production" ? [createLogger()] : [],
});
