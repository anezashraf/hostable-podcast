import axios from 'axios'

export const GET_EPISODES_REQUESTED = 'episode/GET_EPISODES_REQUESTED'
export const GET_EPISODES_RESPONSED = 'episode/GET_EPISODES_RESPONSED'
export const SAVE_EPISODE_REQUEST = 'episode/SAVE_DETAILS_REQUEST'
export const SAVE_NEW_EPISODE_REQUEST = 'episode/SAVE_NEW_EPISODE_REQUEST'
export const SAVE_EPISODE_RESPONSE = 'episode/SAVE_DETAILS_RESPONSED'

export const UPLOAD_EPISODE_IMAGE_REQUEST = 'episode/UPLOAD_IMAGE_REQUEST'
export const UPLOAD_EPISODE_IMAGE_RESPONSE = 'episode/UPLOAD_IMAGE_RESPONSE'

export const UPLOAD_EPISODE_AUDIO_REQUEST = 'episode/UPLOAD_AUDIO_REQUEST'
export const UPLOAD_EPISODE_AUDIO_RESPONSE = 'episode/UPLOAD_AUDIO_RESPONSED'

const initialState = {
  episodes: [],
  isAudioUploading: false,
  isNewEpisodeSaving: false
}

export default (state = initialState, action) => {
  switch (action.type) {
    case GET_EPISODES_REQUESTED:
      return {
        ...state,
        isLoading: true
      }

    case UPLOAD_EPISODE_IMAGE_REQUEST:
      return {
        ...state,
        isImageUploading: true

      }

    case UPLOAD_EPISODE_AUDIO_REQUEST:
      return {
        ...state,
        isAudioUploading: true
      }

    case SAVE_NEW_EPISODE_REQUEST:
      return {
        ...state,
        isNewEpisodeSaving: true
      }

    case UPLOAD_EPISODE_AUDIO_RESPONSE: case UPLOAD_EPISODE_IMAGE_RESPONSE: {
      let id = action.payload.data.id
      let newEpisodes = state.episodes
      newEpisodes[id - 1] = action.payload.data

      return {
        ...state,
        episodes: newEpisodes,
        isAudioUploading: false,
        isNewEpisodeSaving: false,
        isImageUploading: false
      }
    }
    case GET_EPISODES_RESPONSED: {
      let episodes = action.payload.data

      return {
        ...state,
        episodes: episodes,
        isLoading: false
      }
    }

    default:
      return state
  }
}

export const fetchEpisodes = () => {
  return dispatch => {
    dispatch({
      type: GET_EPISODES_REQUESTED
    })

    fetch('/api/episodes')
      .then(function (response) {
        return response.json()
      }).then(function (jsonResponse) {
        dispatch({
          type: GET_EPISODES_RESPONSED,
          payload: jsonResponse
        })
      })
  }
}

export const updateEpisode = (id, data) => {
  return dispatch => {
    dispatch({
      type: SAVE_EPISODE_REQUEST
    })

    axios.patch(`/api/episode/${id}`, data)
      .then(function () {
      })
      .catch(function () {
      })
  }
}

export const uploadImage = (file, id) => {
  return dispatch => {
    dispatch({
      type: UPLOAD_EPISODE_IMAGE_REQUEST
    })

    let formData = new FormData()
    formData.append('file', file)

    axios.post(`/api/fileupload/episode/${id}/image`,
      formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    ).then(function (response) {
      dispatch({
        type: UPLOAD_EPISODE_IMAGE_RESPONSE,
        payload: response.data
      })
    })
      .catch(function () {
      })
  }
}

export const uploadAudio = (file, id) => {
  return dispatch => {
    dispatch({
      type: UPLOAD_EPISODE_AUDIO_REQUEST
    })

    let formData = new FormData()
    formData.append('file', file)

    axios.post(`/api/fileupload/episode/${id}/enclosureUrl`,
      formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    ).then(function (response) {
      dispatch({
        type: UPLOAD_EPISODE_AUDIO_RESPONSE,
        payload: response.data
      })
    }).catch(function () {
    })
  }
}

export const saveNew = (title, description, audio, image) => {
  return dispatch => {
    dispatch({
      type: SAVE_NEW_EPISODE_REQUEST
    })

    let data = {
      title: title,
      description: description
    }

    axios.put(`/api/episodes`,
      data, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    ).then(function (response) {

      let formData = new FormData()
      formData.append('file', audio)

      axios.post(`/api/fileupload/episode/${response.data.id}/enclosureUrl`,
        formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      ).then(function (response) {
        dispatch({
          type: UPLOAD_EPISODE_AUDIO_RESPONSE,
          payload: response.data
        })
      }).catch(function () {
      })

      formData = new FormData()
      formData.append('file', image)

      axios.post(`/api/fileupload/episode/${response.data.id}/image`,
        formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      ).then(function (response) {
        dispatch({
          type: UPLOAD_EPISODE_IMAGE_RESPONSE,
          payload: response.data
        })
      })
        .catch(function () {
        })
    })
  }
}
