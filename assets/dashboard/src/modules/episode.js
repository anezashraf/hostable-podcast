import axios from 'axios';
import {SAVE_DETAILS_REQUEST} from "./podcast";

export const GET_EPISODES_REQUESTED = 'episode/GET_EPISODES_REQUESTED';
export const GET_EPISODES_RESPONSED = 'episode/GET_EPISODES_RESPONSED';
export const SAVE_EPISODE_REQUEST = 'episode/SAVE_DETAILS_REQUEST';
export const SAVE_EPISODE_RESPONSE = 'episode/SAVE_DETAILS_RESPONSED';

const initialState = {
  episodes: []
};

export default (state = initialState, action) => {
  switch (action.type) {
    case GET_EPISODES_REQUESTED:
      console.log("loading1");
      return {
        ...state,
        isLoading: true
      };


    case GET_EPISODES_RESPONSED:
      console.log("s");
      let episodes = action.payload.data;
      console.log(episodes)
      return {
        ...state,
        episodes: episodes,
        isLoading: false
      };

    default:
      return state
  }
}

export const fetchEpisodes = () => {
  return dispatch => {
    dispatch({
      type: GET_EPISODES_REQUESTED
    });

    fetch('/api/episodes')
        .then(function(response) {
          return response.json()
        }).then(function (jsonResponse) {
          dispatch({
            type: GET_EPISODES_RESPONSED,
            payload: jsonResponse
          });
        });
  }
};

export const updateEpisode = (id, data) => {
  return dispatch => {
    dispatch({
      type: SAVE_EPISODE_REQUEST
    });


    console.log(id);
    console.log("ross");
    axios.patch(`/api/episode/${id}`, data)
        .then(function (response) {
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });
  }
};