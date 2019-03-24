import axios from 'axios'
import {
  FETCH_USER_LINK_REQUEST,
  FETCH_USER_LINK_RESPONSE,
  FETCH_USERS_REQUEST, FETCH_USERS_RESPONSE,
  UPDATE_USER_REQUEST, UPDATE_USER_RESPONSE
} from "../Actions/userActions";

const initialState = {
  users: [],
  isLoading: false,
  invitationLink: ''
}

export default (state = initialState, action) => {
  switch (action.type) {
    case FETCH_USERS_REQUEST:
      return {
        ...state,
        isLoading: true
      }

    case FETCH_USER_LINK_REQUEST:
      return {
        ...state
      }

    case FETCH_USER_LINK_RESPONSE:
      return {
        ...state,
        invitationLink: action.payload.data.message
      }

    case UPDATE_USER_REQUEST:

      return {
        ...state,
        isLoading: true
      }

    case UPDATE_USER_RESPONSE: {
      let id = action.payload.data.id
      let newUsers = [...state.users]
      newUsers[id - 1] = action.payload.data

      return {
        ...state,
        users: newUsers,
        isLoading: false
      }
    }
    case FETCH_USERS_RESPONSE:
      return {
        ...state,
        users: action.payload,
        isLoading: false
      }

    default:
      return state
  }
}

export const fetchInvitationLink = () => {
  return dispatch => {
    dispatch({
      type: FETCH_USER_LINK_REQUEST
    })

    fetch('/api/users/invitation-link')
      .then(function (response) {
        return response.json()
      }).then(function (jsonResponse) {
        dispatch({
          type: FETCH_USER_LINK_RESPONSE,
          payload: jsonResponse
        })
      })
  }
}

export const fetchUsers = () => {
  return dispatch => {
    dispatch({
      type: FETCH_USERS_REQUEST
    })

    fetch('/api/users')
      .then(function (response) {
        return response.json()
      }).then(function (jsonResponse) {
        dispatch({
          type: FETCH_USERS_RESPONSE,
          payload: jsonResponse
        })
      })
  }
}

export const updateUser = (id, value) => {
  return dispatch => {
    dispatch({
      type: UPDATE_USER_REQUEST
    })

    let data = [
      { op: 'replace', path: '/enabled', value: value }
    ]

    axios.patch(`/api/user/${id}`, data)
      .then(function (response) {
        dispatch({
          type: UPDATE_USER_RESPONSE,
          payload: response.data
        })
      })
      .catch(function () {
      })
  }
}
