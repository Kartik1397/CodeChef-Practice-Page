// React
import React from 'react';

import ProblemList from './problem/ProblemList';
import SelectTag from './tag/SelectTag';
import PopUp from './tag/Popup';

import { connect } from 'react-redux'
import { getProblems } from '../actions/problemActions';
import { getTags } from '../actions/tagsAction';

import './practicepage.css';

class PracticePage extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      open: false
    }

    this.changeDifficulty = this.changeDifficulty.bind(this);
    this.hidePopUp = this.hidePopUp.bind(this);
  }

  changeDifficulty(e) {
    const { tags, custom_tags, author } = this.props.problems;

    if (e.target.id === 'any') {
      this.props.getProblems("", tags, custom_tags, author);
    } else {
      this.props.getProblems(e.target.id, tags, custom_tags, author);
    }
    document.querySelector('.active').className = "button";
    e.target.className += " active";
  }

  hidePopUp() {
    this.setState({ open: false })
  }

  render() {
    const tagOptions = this.props.tags.tags.map(tag => {
      return ({value: tag.name, label: tag.name, type: tag.type, id: tag.id});
    })
    let popup = "";
    if (this.state.open) {
      popup = <PopUp close={this.hidePopUp} tags={this.props.tags.tags}/>
    }
    return (
      <div className="page">
        <div className="container">
          <div className="section">
            <div className="title">Diffuculty</div>
            <div className="buttons">
              <div id="school" className="button active" onClick={this.changeDifficulty}>Beginner</div>
              <div id="easy" className="button" onClick={this.changeDifficulty}>Easy</div>
              <div id="medium" className="button" onClick={this.changeDifficulty}>Medium</div>
              <div id="hard" className="button" onClick={this.changeDifficulty}>Hard</div>
              <div id="any" className="button" onClick={this.changeDifficulty}>Any</div>
            </div>
          </div>
          <div className="section">
            <div className="title">Filter</div>
            <div className="filter buttons">
              <SelectTag options={tagOptions}></SelectTag>
              <div className="button" onClick={() => { this.setState({open: true})}}>Show All</div>
            </div>
          </div>
          { popup }
          <div className="section">
            <div className="title">Problems</div>
            <div className="table-section">
              <ProblemList></ProblemList>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

var mapStateToProps = state => ({
  tags: state.tags,
  problems: state.problems
});

export default connect(
  mapStateToProps,
  { getProblems, getTags }
)(PracticePage);
