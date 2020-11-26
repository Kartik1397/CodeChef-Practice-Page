// React
import React from 'react';
import BeatLoader from 'react-spinners/BeatLoader';

// Redux
import { connect } from 'react-redux';
import { getProblems } from '../../actions/problemActions';

// Components
import ProblemRow from './ProblemRow';

class ProblemList extends React.Component {
  constructor(props) {
    super(props);
  }

  componentDidMount() {
    this.props.getProblems('school', this.props.problems.tags, this.props.problems.custom_tags, this.props.problems.author);
  }

  render() {
    const { problems, problemsLoading } = this.props.problems;
    const { problemTagMap, tags, idIndexMap } = this.props.tags;
    const tableHeader = (
      <div className="row head">
        <div className="col">#</div>
        <div className="col">Name</div>
        <div className="col">Accuracy</div>
        <div className="col">Submission</div>
        {
          this.props.auth.isAuthenticated
          ? <div className="col">+</div>
          : <div></div>          
        }
      </div>
    );

    let loading = '';
    if (problemsLoading === true) {
      loading = <BeatLoader size={10} />;
    }

    return (
      <div className="table">
        { loading }
        { tableHeader }
        {
          problems.map((problem, key) => {
            var custom_tags = [];
            if (problemTagMap[problem.id] !== undefined) { 
              custom_tags = problemTagMap[problem.id].map(tid => {
                return tags[idIndexMap[tid]];
              });
            }
            return (
              <ProblemRow
                key = {key}
                id = {key+1}
                pid = {problem.id}
                name = {problem.name}
                accuracy = {problem.accuracy}
                submission = {problem.submissions}
                tags = { problem.tags }
                custom_tags = { custom_tags }
                author = { problem.author }
              ></ProblemRow>
            );
          })
        }
      </div>
    );
  }
}

const mapStateToProps = state => ({
  problems: state.problems,
  tags: state.tags,
  auth: state.auth
});

export default connect(
  mapStateToProps,
  { getProblems }
)(ProblemList);