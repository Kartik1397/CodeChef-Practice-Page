import {
  GET_PROBLEMS,
  PROBLEMS_LOADING
} from '../actions/problemActions';

const initialState = {
  problems: [],
  problemsLoading: false,
  difficulty: '',
  tags: '',
  custom_tags: '',
  author: ''
};

export default function (state=initialState, action) {
  switch (action.type) {
    case GET_PROBLEMS:
      var idIndexMap = {};
      action.payload.problems.forEach((tag, idx) => {
        idIndexMap[tag.id] = idx;
      });
      return {
        ...state,
        problems: action.payload.problems,
        difficulty: action.payload.difficulty,
        tags: action.payload.tags,
        problemsLoading: false,
        idIndexMap: idIndexMap,
        custom_tags: action.payload.custom_tags,
        author: action.payload.author
      };
    case PROBLEMS_LOADING:
      return {
        ...state,
        problemsLoading: true
      }
    default:
      return state;
  }
}