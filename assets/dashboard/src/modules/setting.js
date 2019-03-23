import axios from 'axios'

export const FETCH_SETTINGS_REQUEST = 'settings/GET_SETTINGS_REQUEST'
export const FETCH_SETTINGS_RESPONSE = 'settings/GET_SETTINGS_RESPONSE'

export const UPDATE_SETTING_REQUEST = 'settings/UPDATE_SETTING_REQUEST'
export const UPDATE_SETTING_RESPONSE = 'settings/UPDATE_SETTING_RESPONSE'

const initialState = {
  settings: [],
  isLoading: false
}

export default (state = initialState, action) => {
  switch (action.type) {
    case FETCH_SETTINGS_REQUEST:
      return {
        ...state,
        isLoading: true
      }

    case UPDATE_SETTING_REQUEST:
      return {
        ...state,
        isLoading: true
      }

    case FETCH_SETTINGS_RESPONSE:
      return {
        ...state,
        settings: action.payload,
        isLoading: false
      }

    default:
      return state
  }
}

export const fetchSettings = () => {
  return dispatch => {
    dispatch({
      type: FETCH_SETTINGS_REQUEST
    })

    fetch('/api/settings')
      .then(function (response) {
        return response.json()
      }).then(function (jsonResponse) {
        dispatch({
          type: FETCH_SETTINGS_RESPONSE,
          payload: jsonResponse
        })
      })
  }
}

export const updateSetting = (id, value) => {
  return dispatch => {
    dispatch({
      type: UPDATE_SETTING_REQUEST
    })

    let data = [
      { op: 'replace', path: '/value', value: value.toString() }
    ]

    axios.patch(`/api/settings/${id}`, data)
      .then(function (response) {
        dispatch({
          type: UPDATE_SETTING_RESPONSE,
          payload: response.data
        })
      })
      .catch(function () {
      })
  }
}
