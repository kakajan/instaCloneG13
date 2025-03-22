import { defineStore, acceptHMRUpdate } from 'pinia'

export const useAppData = defineStore('appData', {
  state: () => ({
    posts: [],
    currentPostIndex: null,
    user: null
  }),
  getters: {},
  actions: {}
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useAppData, import.meta.hot))
}
