import {
  CREATE_TAG,
  GET_TAGS,
  DELETE_TAG,
  SET_MAP,
  TAGS_LOADING
} from '../actions/tagsAction';

const initialState = {
  tags: [],
  idIndexMap: [],
  tagProblemMap: [],
  problemTagMap: [],
  tagsLoading: false
};

export default function(state = initialState, action) {
  switch (action.type) {
    case GET_TAGS:
      var idIndexMap = {};
      action.payload.forEach((tag, idx) => {
        idIndexMap[tag.id] = idx;
      });
      return {
        ...state,
        tags: action.payload,
        idIndexMap: idIndexMap,
        tagsLoading: false
      };
    case CREATE_TAG:
      return {
        ...state,
        tagsLoading: false
      };
    case DELETE_TAG:
      return {
        ...state,
        tagsLoading: false
      };
    case SET_MAP:
      var tagProblemMap = {};
      var problemTagMap = {};
      action.payload.forEach(map => {
        if (tagProblemMap[map.tid] === undefined)
          tagProblemMap[map.tid] = [];
        tagProblemMap[map.tid].push(map.pid);
      })
      action.payload.forEach(map => {
        if (problemTagMap[map.pid] === undefined)
        problemTagMap[map.pid] = [];
        problemTagMap[map.pid].push(map.tid);
      })

      return {
        ...state,
        tagProblemMap: tagProblemMap,
        problemTagMap: problemTagMap,
        tagsLoading: false
      }
    case TAGS_LOADING:
      return {
        ...state,
        tagsLoading: true,
      }
    default:
      return state;
  }
}