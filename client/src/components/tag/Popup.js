import React from 'react';
import '../common/popup.css';

class PopUp extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      active: 'author'
    }
    this.handleClick = this.handleClick.bind(this);
  }

  handleClick(e) {
    this.setState({
      active: e.target.id
    })
    document.querySelector(".active-tag-title").className = "tagtype-title";
    e.target.className += " active-tag-title";
  }

  render() {
    const { tags } = this.props;

    return (
      <div className="popup-container">
        <div className="outside" onClick={() => { this.props.close(); }}></div>
        <div className="popup-card">
          <div className="tagtype-titles">
            <div id="author" className="tagtype-title active-tag-title" onClick={this.handleClick}>Author</div>
            <div id="actual_tag" className="tagtype-title" onClick={this.handleClick}>Algorithm</div>
            <div id="custom_tag" className="tagtype-title" onClick={this.handleClick}>Custom</div>
          </div>
          <div className="tags">
          {
            tags.filter(tag => tag.type===this.state.active).map(tag => {
              return(
                <div className="tag" key={tag.id} id={tag.id}>{tag.name} &nbsp; <span>x{tag.count}</span></div>
              )
            })
          }
          </div>
        </div>
      </div>
    );
  }
}

export default PopUp;