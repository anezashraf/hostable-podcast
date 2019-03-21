import { combineReducers } from 'redux'
import setting from './setting'
import podcast from './podcast'
import episode from './episode'
import user from './users'

export default combineReducers({
  podcast,
  setting,
  user,
  episode
})
