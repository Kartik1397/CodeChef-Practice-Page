import axios from "axios";
import { API } from '../config';

export const GET_PROBLEMS = 'GET_PROBLEMS';
export const PROBLEMS_LOADING = 'PROBLEMS_LOADING';

export const getProblems = (difficulty, tags, custom_tags, author="") => dispatch => {
  dispatch(setProblemsLoading());
  if (localStorage.jwtToken === undefined) {
    axios
    .get(API + `/problems?difficulty=${difficulty}&author=${author}&tags=${tags}`)
    .then(res => {

      return dispatch({
        type: GET_PROBLEMS,
        payload: {
          ...res.data,
          difficulty,
          tags,
          custom_tags,
          author
        }});
    })
  } else {
    axios
      .get(API + `/problems?difficulty=${difficulty}&author=${author}&tags=${tags}&custom_tags=${custom_tags}`)
      .then(res => {
        return dispatch({
          type: GET_PROBLEMS,
          payload: {
            ...res.data,
            difficulty,
            tags,
            custom_tags,
            author
          }});
      })
  }
};

export const setProblemsLoading = () => {
  return {
    type: PROBLEMS_LOADING
  };
}