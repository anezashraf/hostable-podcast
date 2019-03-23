import axios from 'axios'

export const GET_DETAILS_REQUESTED = 'podcast/GET_DETAILS_REQUESTED'
export const GET_DETAILS_RESPONSED = 'podcast/GET_DETAILS_RESPONSED'

export const SAVE_DETAILS_REQUEST = 'podcast/SAVE_DETAILS_REQUEST'
export const SAVE_DETAILS_RESPONSE = 'podcast/SAVE_DETAILS_RESPONSED'

export const UPLOAD_IMAGE_REQUEST = 'podcast/UPLOAD_IMAGE_REQUEST'
export const UPLOAD_IMAGE_RESPONSE = 'podcast/UPLOAD_IMAGE_RESPONSE'

const initialState = {
  title: '',
  description: '',
  id: '',
  isImageUploading: false
}

export default (state = initialState, action) => {
  switch (action.type) {
    case GET_DETAILS_REQUESTED:
      return {
        ...state,
        isLoading: true
      }

    case GET_DETAILS_RESPONSED: case UPLOAD_IMAGE_RESPONSE:
      return {
        ...state,
        title: action.payload.data.title,
        id: action.payload.data.id,
        image: action.payload.data.image,
        description: action.payload.data.description,
        isLoading: false,
        isImageUploading: false
      }

    case SAVE_DETAILS_REQUEST:
      return {
        ...state,
        isLoading: true
      }

    case UPLOAD_IMAGE_REQUEST:
      return {
        ...state,
        isImageUploading: true
      }

    case SAVE_DETAILS_RESPONSE:
      return {
        ...state
      }

    default:
      return state
  }
}

export const fetchDetails = () => {
  return dispatch => {
    dispatch({
      type: GET_DETAILS_REQUESTED
    })

    fetch('/api/podcast')
      .then(function (response) {
        return response.json()
      }).then(function (jsonResponse) {
        dispatch({
          type: GET_DETAILS_RESPONSED,
          payload: jsonResponse
        })
      })
  }
}

export const updateDetails = (title, description) => {
  return dispatch => {
    dispatch({
      type: SAVE_DETAILS_REQUEST
    })

    let data = [
      { op: 'replace', path: '/title', value: title },
      { op: 'replace', path: '/description', value: description }
    ]

    axios.patch('/api/podcast', data)
      .then(function () {
      })
      .catch(function () {
      })
  }
}

export const uploadImage = (file) => {
  return dispatch => {
    dispatch({
      type: UPLOAD_IMAGE_REQUEST
    })

    let formData = new FormData()
    formData.append('file', file)

    axios.post(`/api/fileupload/podcast/1/image`,
      formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    ).then(function (response) {
      dispatch({
        type: UPLOAD_IMAGE_RESPONSE,
        payload: response.data
      })
    })
      .catch(function () {
      })
  }
}
