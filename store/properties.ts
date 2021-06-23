import { 
  SET_VIEWING, 
  ADD_PROPERTY, 
  REMOVE_PROPERTY, 
  SET_BUYING_FLAG,
  TOGGLE_INTERESTED
} from './mutation-types'
import {  LOAD_PROPERTIES } from './action-types'
import { State, Property } from '../types'


export const state = ():State => ({
  list: [],
  viewing: -1,
  interested: [],
  buying:true
})

export const mutations = {
  [ADD_PROPERTY](state:State, property: Property) {
    state.list.push(property)
  },
  [REMOVE_PROPERTY](state: State,  property:Property) {
    state.list.splice(state.list.indexOf(property), 1);
  },
  [SET_VIEWING](state:State, id:number) {
    state.viewing = id;
  },
  [SET_BUYING_FLAG](state:State, flag:boolean) {
    state.buying = flag;
  },
  [TOGGLE_INTERESTED](state:State, id:number) {
    const property = state.list.find((property:Property) => property.id === id);
    if (property) {
      property.interested = !property.interested;
    }
  },
  clear(state:State) {
    state.list = [];
    state.viewing = -1;
    state.interested = [];
    state.buying = false;
  }
}
export const getters = {
  getPropertyById: (state:State) => (id:number) => { 
    return state.list.find((property) => property.id === id )
  },
  getCurrentViewingProperty: (state:State) => {
    return state.list.find((property) => property.id === state.viewing) 
  },
  getProperties: (state:State) => {
    return state.list.filter((property:Property) => property.buying === state.buying)
  },
  isBuying: (state:State) => () => state.buying
}

 export const actions = {
  async [LOAD_PROPERTIES]({commit, state}) {
    commit('clear');
    const data = await fetch('/data.json');
    data.json().then(jsonData => {
      jsonData.properties.forEach(( property:Property ) => commit(ADD_PROPERTY, property));
    }).finally(() => {
      if (state.list.length > 0) {
        console.log(state.list.length)
        commit(SET_VIEWING, state.list[0].id)
      }
    })
    }
  }
