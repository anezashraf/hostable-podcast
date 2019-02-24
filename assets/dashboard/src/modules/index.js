import { combineReducers } from 'redux'
import setting from './setting'
import podcast from './podcast'
import episode from './episode'

export default combineReducers({
  podcast,
  setting,
  episode
})
