// React
import React from 'react';
import BeatLoader from 'react-spinners/BeatLoader';

// Redux
import { connect } from 'react-redux';
import { mapTagProblem } from '../../actions/tagsAction';

class AddTag extends React.Component {
  constructor(props) {
    super(props);

    this.handleClick = this.handleClick.bind(this);
  }

  handleClick(e) {
    this.props.mapTagProblem({tid: e.target.id, pid: this.props.pid});
  }

  render() {
    const { tags, tagsLoading } = this.props.tags;
    
    let loading = '';
    if (tagsLoading === true) {
      loading = <BeatLoader size={10} />;
    }

    return (
      <div className="popup-container">
        <div className="outside" onClick={() => { this.props.close(); }}></div>
        <div className="flex-popup-card">
          <div>Select Tag</div>
          { loading }
          <div className="add-tags">
          {
            tags.filter(tag => tag.type==='custom_tag' && !this.props.custom_tags.includes(tag)).map(tag => {
              return(
                <div className="tag" id={tag.id} key={tag.id} onClick={this.handleClick}>{tag.name} &nbsp; <span>x{tag.count}</span></div>
              )
            })
          }
          </div>
        </div>
      </div>
    );
  }
}
var mapStateToProps = state => ({
  tags: state.tags
});

export default connect(
  mapStateToProps,
  { mapTagProblem }
)(AddTag);
