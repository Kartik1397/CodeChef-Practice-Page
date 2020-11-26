// React
import React from 'react';
import AsyncSelect from 'react-select/async';

// Redux
import { connect } from 'react-redux';
import { getTags } from '../../actions/tagsAction';
import { getProblems } from '../../actions/problemActions';

// Styles
import './selectTag.css';

class SelectTag extends React.Component {
  constructor(props) {
    super(props);
    this.loadOptions = this.loadOptions.bind(this);
  }

  loadOptions(value, callback) {
    if (value.length > 0) {
      const regex = new RegExp(`^${value}`, 'i');
      callback(this.props.options.filter(v => regex.test(v.label)));
    }
  }

  handleChange = (selectedOptions) => {
    let tags = "",
        custom_tags = "",
        author = "";
    
    if (selectedOptions !== null) {
      selectedOptions.forEach((option, idx) => {
        if (option.type === 'author') {
          author = option.value
        } else if(option.type === 'custom_tag') {
          custom_tags += option.id + ",";
        } else {
          tags += option.value + ",";
        }
      });
      tags = tags.slice(0, -1);
      custom_tags = custom_tags.slice(0, -1);
    }
    this.props.getProblems(this.props.problems.difficulty, tags, custom_tags, author);
  }

  render() {
    const customStyles = {
      control: (provided) => ({
        ...provided,
        height: 45,
        border: "none",
        borderRadius: 5,
        boxShadow: 'none'
      }),
      placeholder: (provided) => ({
        ...provided,
        fontSize: 14
      }),
      menu: (styles) => {
        return {
          ...styles,
          border: "none",
          borderRadius: 5,
          borderWidth: 0,
          boxShadow: '2px 5px 7px 0 rgba(0, 0, 0, 0.08)',
          marginTop: -6
        }
      },
      multiValueLabel: (styles) => {
        return {
          ...styles,
          padding: 0,
          paddingLeft: 0,
          lineHeight: 1.7,
        }
      },
      option: (styles) => {
        return {
          ...styles,
          fontSize: 14,
        }
      }
    }

    const formatOptionLabel = ({ value, label, type }) => (
      <div style={{display: "flex"}}>
        {
          <div
            style={{
              backgroundColor: type==='custom_tag'
                ? "rgba(247, 209, 17, 0.6)"
                : type === 'author'
                ? "rgba(17, 209, 247, 0.6)"
                :"rgba(52, 235, 100, 0.6)",
              borderRadius: 2,
              marginRight: 5,
              paddingLeft: 5,
              paddingRight: 5,
              fontSize: 12,
              fontWeight: 600,
              display: "flex",
              color: "rgba(0, 0, 0, 0.45)",
              alignItems: "center",
            }}
          >
            {
              type === 'author'
              ? "A"
              : type === 'actual_tag'
              ? "T"
              : type === 'custom_tag'
              ? "C"
              : " "
            }
          </div>
        }
        <div>{label}</div>
      </div>
    );
    
    return (
      <>
        <AsyncSelect
          styles={customStyles}
          className="input"
          isMulti
          name="colors"
          placeholder="Select Tags"
          cacheOptions
          loadOptions={this.loadOptions}
          onChange={this.handleChange}
          formatOptionLabel={formatOptionLabel}
          noOptionsMessage={() => "Type Something"}
          components={{ DropdownIndicator:() => null, IndicatorSeparator:() => null }}
        />
      </>
    );
  }
}

const mapStateToProps = state => ({
  tags: state.tags,
  problems: state.problems
});

export default connect(
  mapStateToProps,
  { getTags, getProblems }
)(SelectTag);
