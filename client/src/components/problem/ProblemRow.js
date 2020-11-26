import React from 'react';
import AddTag from '../tag/AddTag';

import { connect } from 'react-redux';
import { unmapTagProblem } from '../../actions/tagsAction';

class ProblemRow extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      addTag: false
    }
    this.openAddTagPopUp = this.openAddTagPopUp.bind(this);
    this.close = this.close.bind(this);
  }

  openAddTagPopUp() {
    this.setState({addTag: true});
  }

  close() {
    this.setState({addTag: false});
  }

  render() {
    const { id, pid, name, accuracy, submission, tags, custom_tags } = this.props;
    return(
      <>
        <div className="row">
          <div className="col">{id}</div>
          <div className="col">
            <div>{name}</div>
            <div className="problem-tags">
              {
                <div className="problem-tag author-tag" title="Author">{this.props.author}</div>
              }
              {
                tags.map((tag, idx) => {
                  return (<div key={idx} className="problem-tag" title="Tag">{tag}</div>)
                })
              }
              {
                custom_tags.map((tag, idx) => {
                  if (tag === undefined) {
                    return;
                  }
                  return (
                    <div key={idx} className="problem-tag custom-tag" title="Custom Tag">
                      {tag.name}
                      <span
                        style={{color: 'red', cursor: 'pointer'}}
                        onClick={() => {
                          this.props.unmapTagProblem({tid: tag.id, pid: pid});
                        }}
                      > x </span>
                    </div>
                  )
                })
              }
            </div>
          </div>
          <div className="col">{accuracy}</div>
          <div className="col">{submission}</div>
          {
            this.props.auth.isAuthenticated
            ? <div className="col add-tag-button" title="Add Custom Tag" onClick={this.openAddTagPopUp}>+</div>
            : <div></div>
          }
        </div>
        { this.state.addTag === true ? <AddTag custom_tags={custom_tags} pid={pid} close={this.close}></AddTag> : "" }
      </>
    );
  }
}

var mapStateToProps = state => ({
  auth: state.auth
})

export default connect(
  mapStateToProps,
  { unmapTagProblem }
)(ProblemRow);