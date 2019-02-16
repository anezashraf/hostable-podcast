import { combineReducers } from 'redux'
import counter from './counter'
import podcast from './podcast'
import episode from './episode'

export default combineReducers({
  counter,
  podcast,
  episode
})
