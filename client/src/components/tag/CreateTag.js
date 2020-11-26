// React
import React from 'react';
import BeatLoader from 'react-spinners';

// Redux
import { connect } from 'react-redux';
import { createTag } from '../../actions/tagsAction';

// Styles
import '../common/popup.css';
import '../common/form.css';

class CreateTag extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      name: ''
    }

    this.handleChanges = this.handleChanges.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleChanges(e) {
    this.setState({
      [e.target.name]: e.target.value
    })
  }

  handleSubmit(e) {
    e.preventDefault();
    this.props.createTag(this.state);
    this.props.close();
  }

  render() {
    return (
      <div className="popup-container">
        <div className="outside" onClick={() => { this.props.close(); }}></div>
        <div className="flex-popup-card">
          <form className="form" onSubmit={this.handleSubmit}>
            <div className="form-input">
              <label htmlFor="tagname">Name</label>
              <input type="text" id="tagname" name="name" onChange={this.handleChanges} required></input>
            </div>
            <div className="submit">
              <input type="submit" className="form-button" value="Create Tag"></input>
            </div>
          </form>
        </div>
      </div>
    );
  }
}

var mapStateToProps = state => ({});

export default connect(
  mapStateToProps,
  { createTag }
)(CreateTag);
