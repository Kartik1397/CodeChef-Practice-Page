// React
import React from 'react';
import { Redirect } from 'react-router-dom';
import BeatLoader from 'react-spinners/BeatLoader';

//Redux
import { connect } from 'react-redux';
import { getTags, removeTag } from '../../actions/tagsAction';

// Components
import CreateTag from '../tag/CreateTag';

// Style
import './userpage.css';

class UserPage extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      createTag: false
    }

    this.close = this.close.bind(this);
    this.deleteTag = this.deleteTag.bind(this);
  }

  close() {
    this.setState({ createTag: false });
  }

  deleteTag(e) {
    this.props.removeTag({id: e.target.id});
  }

  render() {
    if (!this.props.auth.isAuthenticated) {
      return (
        <Redirect to="/"/>
      );
    }
    const { user } = this.props.auth;
    const { tags, tagsLoading } = this.props.tags;
    
    var createTagPopUp = "";
    if (this.state.createTag === true) {
      createTagPopUp = <CreateTag close={this.close}></CreateTag>;
    }

    let loading = '';
    if (tagsLoading === true) {
      loading = <BeatLoader size={10} />;
    }

    return (
      <div className="user-page">
        <div className="username">{user.username}</div>
        <div className="title">Info</div>
        <div className="fullname">
          <div className="label">Name:</div>
          <div className="firstname">{user.first_name}</div>
          <div className="lastname">{user.last_name}</div>
        </div>
        <div className="fullname">
          <div className="label">Email:</div>
          <div className="firstname">{user.email}</div>
        </div>
        <div>
          <br></br>
          <div className="title">Custom Tag</div>
          { loading }
          <div className="button" onClick={() => { this.setState({createTag: true})}}>Create Tag</div>
        </div>
        <div className="tag-box">
          {
            tags.filter(tag => tag.type === 'custom_tag').map(tag => {
              return (
                <div className="tag" key={tag.id}>{tag.name} &nbsp; <span>x{tag.count} <span id={tag.id} className="cross" onClick={this.deleteTag}>X</span></span></div>
              );
            })
          }
        </div>
        { createTagPopUp }
      </div>
    );
  }
}

var mapStateToProps = state => ({
  auth: state.auth,
  tags: state.tags
})

export default connect(
  mapStateToProps,
  { getTags, removeTag }
)(UserPage);